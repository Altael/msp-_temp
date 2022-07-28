<?php

namespace App\Http\Controllers;

use App\Http\MP3File;
use App\Models\User\User;
use App\MspMedia;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function test(Request $request) {
        $request->validate([
            'slim_output_0' => 'required|file'
        ]);

        $file = $request->file('slim_output_0');

        $file_extension = $file->extension();

        $file_name = 'slim_fotka';

        $file->storeAs('', $file_name . '.' . $file_extension, 'media');
    }

    public function upload(Request $request) {
        $request->validate([
            'file' => 'required|file'
        ]);

        $file = $request->file('file');

        $file_extension = $file->extension();

        $file_name = $request->fileName ? $request->fileName.'.'.$file_extension : $file->getClientOriginalName();

        $mime = $file->getMimeType();

        if(strstr($mime, "video/")) {
            $file_mime = 'video';
        } else if(strstr($mime, "image/")) {
            $file_mime = 'image';
        } else if(strstr($mime, "audio/")) {
            $file_mime = 'audio';
        }

        try{
            $media = MspMedia::create([
                'path' => $file_name,
                'type' => $file_mime,
                'source' => 'file'
            ]);

            $file->storeAs('', $file_name, 'media');

            return [
                'status' => 'ok'
            ];
        } catch(\Exception $e) {
            $response = 'fail';
            if(strstr($e, 'Integrity constraint violation: 1062')) {
                $response = 'This name already taken.';
            }

            return [
                'status' => $response
            ];
        }
    }

    public function save() {
        $file = request('file');

        if($file['id']){
            $media = MspMedia::findOrFail($file['id'])->update($file);
        } else {
            $media = MspMedia::create($file);
        }

        return [
            'status' => 'ok'
        ];
    }

    public function list() {
        $files = MspMedia::query();

        if(!request('hidden')) {
            $files->where('hidden', false);
        }

        if($name = request('name')) {
            $files->where('path', 'like', "%{$name}%");
        }

        $total = $files->count();

        $files = $files->skip(request('skip'))->take(request('take'))->latest()->get();


        return [
            'files' => $files,
            'total' => $total
        ];
    }

    public function getAudio() {
        $audio = MspMedia::where('type', 'audio')->where('hidden', false)->latest()->get();

        return [
            'audio' => $audio
        ];
    }

    public function getVideo() {
        $video = MspMedia::where('type', 'video')->where('hidden', false)->latest()->get();

        return [
            'video' => $video
        ];
    }

    public function delete() {
        $file = MspMedia::findOrFail(request('file'));

        if($file->source === 'file') {
            unlink(public_path('media') . '\\' . $file->path);
        }

        $file->delete();

        return [
            'status' => 'ok'
        ];
    }

    public function info() {
        $file = request('file');
        $filepath = public_path('media') . $file;
        $mp3file = new MP3File($filepath);
        $duration = $mp3file->getDuration();
        return [
            'duration' => $duration,
            'name' => str_replace('_', ' ', pathinfo($filepath)['filename'])
        ];
    }

    public function getUserAvatar() {
        $user = User::findOrFail(request('id'));

        if(!($profile = $user->profile)) {
            return;
        }
        $avatar = $profile->image;

        return [
            'src' => $avatar
        ];
    }
}
