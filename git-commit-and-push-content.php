<?php
require(__DIR__ . DS . 'helpers.php');

$gitHelper = new KirbyGitHelper();

/*
* Avatar
*/
kirby()->hook('panel.avatar.upload', function ($avatar) use ($gitHelper){
    $gitHelper->kirbyChange('upload(avatar): ' . $avatar->filename());
});
kirby()->hook('panel.avatar.delete', function ($avatar) use ($gitHelper){
    $gitHelper->kirbyChange('delete(avatar): ' . $avatar->filename());
});

/*
* Pages
*/
kirby()->hook('panel.page.create', function ($page) use ($gitHelper) {
    $gitHelper->kirbyChange('create(page): ' . $page->uri());
});
kirby()->hook('panel.page.update', function ($page) use ($gitHelper) {
    $gitHelper->kirbyChange('update(page): ' . $page->uri());
});
kirby()->hook('panel.page.delete', function ($page) use ($gitHelper){
    $gitHelper->kirbyChange('delete(page): ' . $page->uri());
});
kirby()->hook('panel.page.sort', function ($page) use ($gitHelper){
    $gitHelper->kirbyChange('sort(page): ' . $page->uri());
});
kirby()->hook('panel.page.hide', function ($page) use ($gitHelper){
    $gitHelper->kirbyChange('hide(page): ' . $page->uri());
});
kirby()->hook('panel.page.move', function ($page) use ($gitHelper){
    $gitHelper->kirbyChange('move(page): ' . $page->uri());
});

/*
* File
*/
kirby()->hook('panel.file.upload', function ($file) use ($gitHelper){
    $gitHelper->kirbyChange('upload(file): ' . $file->page()->uri() . '/' . $file->filename());
});
kirby()->hook('panel.file.replace', function ($file) use ($gitHelper){
    $gitHelper->kirbyChange('replace(file): ' . $file->page()->uri() . '/' . $file->filename());
});
kirby()->hook('panel.file.rename', function ($file) use ($gitHelper){
    $gitHelper->kirbyChange('rename(file): ' . $file->page()->uri() . '/' . $file->filename());
});
kirby()->hook('panel.file.update', function ($file) use ($gitHelper){
    $gitHelper->kirbyChange('update(file): ' . $file->page()->uri() . '/' . $file->filename());
});
kirby()->hook('panel.file.sort', function ($file) use ($gitHelper){
    $gitHelper->kirbyChange('sort(file): ' . $file->page()->uri() . '/' . $file->filename());
});
kirby()->hook('panel.file.delete', function ($file) use ($gitHelper){
    $gitHelper->kirbyChange('delete(file): ' . $file->page()->uri() . '/' . $file->filename());
});

/*
* User
*/
kirby()->hook('panel.user.create', function ($user) use ($gitHelper) {
    $gitHelper->kirbyChange('create(user): ' . $user->username());
});
kirby()->hook('panel.user.update', function ($user) use ($gitHelper) {
    $gitHelper->kirbyChange('update(user): ' . $user->username());
});
kirby()->hook('panel.user.delete', function ($user) use ($gitHelper){
    $gitHelper->kirbyChange('delete(user): ' . $user->username());
});

if(c::get('gcapc-cron-hooks-enabled', true)) {
    kirby()->routes(array(
        array(
            'pattern' => 'gcapc/(:any)',
            'action'  => function($gitCommand) use ($gitHelper) {
                switch ($gitCommand) {
                    case "push":
                        $gitHelper->push();
                        break;
                    case "pull":
                        $gitHelper->pull();
                        break;
                }
            }
        )
    ));
}
