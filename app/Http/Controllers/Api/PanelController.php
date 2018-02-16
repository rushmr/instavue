<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Post;
use App\Project;
use App\Setting;
use Storage;
use Validator;

class PanelController extends Controller
{

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function homePanel()
    {

        $settings = Setting::first();
        if($settings->project_id != 0){
            $project = $settings->project->name;
            $futuredPosts = Post::where(['project_id'=>$settings->project_id, 'executed'=>0])->count();
            $executedPosts = Post::where(['project_id'=>$settings->project_id, 'executed'=>1])->count();
        } else {
            $project = 'нет';
            $futuredPosts = '';
            $executedPosts = 0;
        }

        return response()->json(['success'=>1, 'response'=> ['futuredPosts' => $futuredPosts,  'executedPosts' => $executedPosts, 'project' => $project, 'settings' => $settings]]);

    }

    public function settings(){

        return response()->json(['success'=>1, 'response'=> ['projects' => Project::all(),  'settings' => Setting::firstOrFail()]]);
    }

    public function settingsUpdate(Request $request){

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|integer',
            'vk_service_token' => 'required',
            'posts_amount' => 'required',
        ]);

        if(!$validator->passes()){
            return response()->json(['success' => 0, 'error' => 'Необходимые поля не заполнены']);
        }

       $settings = Setting::firstOrFail();
       $settings->project_id = $request->project_id;
       $settings->vk_service_token = $request->vk_service_token;
       $settings->posts_amount = $request->posts_amount;
       $settings->save();
       return response()->json(['success' => 1]);
    }

    public function projects(){
        $projects = Project::all();
        return response()->json(['success' => 1, 'response'=>['projects' =>  $projects]]);
    }

    public function projectStore(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'login' => 'required',
            'feed' => 'required',
            'tags' => 'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['success' => 0, 'error' => 'Необходимые поля не заполнены']);
        }

        $feed = explode("\r\n", $request->feed);
        $tags = explode("\r\n", $request->tags);

        Project::create([
            'name' => $request->name,
            'password' => $request->password,
            'login' => $request->login,
            'feed' => json_encode($feed),
            'tags' => json_encode($tags),
        ]);

        return response()->json(['success' => 1]);
    }

    public function project($id){

        $project = Project::find($id);

        if(!$project){
            return response()->json(['success' => 0, 'error' => 'Такой проект не найден']);
        }

        $feed = json_decode($project->feed);
        $feed = implode("\r\n", $feed);
        $tags = json_decode($project->tags);
        $tags = implode("\r\n", $tags);

        return response()->json(['success' => 1, 'response' => ['project'=>$project, 'feed'=>$feed, 'tags' => $tags]]);
    }

    public function projectUpdate(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'login' => 'required',
            'feed' => 'required',
            'tags' => 'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['success' => 0, 'error' => 'Необходимые поля не заполнены']);
        }

        $feed = explode("\r\n", $request->feed);
        $tags = explode("\r\n", $request->tags);
        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->login = $request->login;
        $project->password = $request->password;
        $project->feed = json_encode($feed);
        $project->tags = json_encode($tags);
        $project->save();

        return response()->json(['success' => 1]);
    }

    public function projectDelete($id){
        $settings = Setting::firstOrFail();
        if($settings->project_id == $id){
            $settings->project_id = 0;
            $settings->save();
        }

        $project = Project::find($id);

         if(!$project){
            return response()->json(['success' => 0, 'error' => 'Такой проект не найден']);
        }

        foreach($project->posts as $p){
            $p->delete();
        }
        $project->delete();

        return response()->json(['success' => 1]);
    }

    public function get(){

        if(Setting::firstOrFail()->project_id == 0){
            return $this->setError('Нужно добавить проект');
        }

        $feed = Setting::firstOrFail()->project->feed;
        $feed = json_decode($feed);
        if(empty($feed)){
            return $this->setError('Нужно добавить источники контента');
        }

        $posts = [];
        $currentPosts = Post::where(['project_id' => Setting::firstOrFail()->project_id])->get()->pluck('post_id')->toArray();

        foreach($feed as $f){
            $data = Vkservice::api('wall.get', [
                'domain' => $f,
                'offset' => rand(1, 300),
                'count' => Setting::firstOrFail()->posts_amount,
                'filter' => 'owner',
                'access_token' => Setting::firstOrFail()->vk_service_token

            ]);
            if(!empty($data['response'])){
                
                foreach($data['response'] as $dt){

                    if(
                        empty($dt['id']) || 
                        empty(trim($dt['text'])) || 
                        strlen($dt['text']) < 300 || 
                        empty($dt['attachment']['photo']) ||
                        in_array('wall'.$dt['from_id'].'_'.$dt['id'], $currentPosts)
                    ) 
                        continue;

                    $posts[] = [
                        //'domain' => $f,
                        'post_id' => 'wall'.$dt['from_id'].'_'.$dt['id'],
                        'thumb' => $dt['attachment']['photo']['src'],
                        'picture_path' => $dt['attachment']['photo']['src_big'],
                        'text' => str_replace("<br>", "\r\n", $dt['text']),
                    ];

                }

            } else {
                $e = (!empty($data['error']['error_msg']) ? $data['error']['error_msg'] : '');
                return $this->setError('Ошибка - метод wall.get', $e);
            }
        }

        if(empty($posts)) {
            return $this->setError('Никаких результатов по парсингу, попробуйте еще раз');
        }

        return view('panel.get')->with('posts', $posts);

    }

/* MOVED TO API ROUTES
    public function postSave(Request $request){

            $this->validate($request, [
                'post_id' => 'required',
                'picture_path' => 'required',
                'text' => 'required'
            ]);

            $settings = Setting::firstOrFail();
            $contents = file_get_contents($request->picture_path);
            $name = time().substr($request->picture_path, strrpos($request->picture_path, '/') + 1);
            $path = 'posts_images/'.$settings->project->name.'/'.$name;
            Storage::put($path, $contents);

            Post::create([
                'project_id' => $settings->project_id,
                'post_id' => $request->post_id,
                'picture_path' => 'storage/app/'.$path,
                'text' => $request->text,
                'executed' => 0
            ]);
            //dd(file_exists(base_path('storage/app/posts_images/3/15184447290kBIlf0YAu0.jpg')));

            return \Response::json(['success' => 'ok']);

    }
*/
    public function post(){

        $settings = Setting::firstOrFail();
        if($settings->project_id == 0){
            return $this->setError('Нужно добавить проект');
        }
        
        $post = Post::where(['project_id' => $settings->project_id, 'executed'=>0])->orderBy('created_at', 'asc')->first();
        if(!$post){
            return $this->setError('Нет запланируемых постов на публикацию');
        }

        $selectedTags = '';
        $tags = array_unique(json_decode($settings->project->tags));
        $num = (count($tags) > 5 ? 5 : 1);
        $randKeys = array_rand($tags, $num);
        foreach($randKeys as $rk){
            $selectedTags .= $tags[$rk]."\r\n";
        }
        $selectedTags = "\r\n".$selectedTags;

        $ig = new Instagram(false, false);
        try {
            $ig->login($settings->project->login, $settings->project->password);
        } catch (\Exception $e) {
            return $this->setError('Ошибка при попытке логина в Instagram - '.$e->getMessage());
        }

        try {
            $photo = new InstagramPhoto(base_path($post->picture_path));
            $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $post->text.$selectedTags]);
            $post->executed = 1;
            $post->save();
            return redirect()->route('home')->with('success', 'Пост отправлен');
        } catch (\Exception $e) {
            return $this->setError('Ошибка при попытке отправки изображения - '.$e->getMessage());
        }
    }

    public function setError($msg, $err = ''){
        $error = (!empty($err) ? $msg.' | '.$err : $msg);
        Session::flash('warning', $error);
        return redirect()->route('home');
    }

    public function postSave(Request $request){

    $validator = Validator::make($request->all(), [
        'post_id' => 'required',
        'picture_path' => 'required',
        'text' => 'required'
    ]);

    if(!$validator->passes()){
    	return response()->json(['success' => 0, 'error' => 'Some of required fields empty']);
    }

    $settings = Setting::firstOrFail();
    $contents = file_get_contents($request->picture_path);
    $name = time().substr($request->picture_path, strrpos($request->picture_path, '/') + 1);
    $path = 'posts_images/'.$settings->project->name.'/'.$name;
    Storage::put($path, $contents);

    Post::create([
        'project_id' => $settings->project_id,
        'post_id' => $request->post_id,
        'picture_path' => 'storage/app/'.$path,
        'text' => $request->text,
        'executed' => 0
    ]);

    return response()->json(['success' => 1]);

    }
}
