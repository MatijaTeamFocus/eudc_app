<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

use Phalcon\Mvc\Micro\Collection as MicroCol;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;


$app->get('/', function () {
    echo $this['view']->render('index');
});

/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});

// Micro controllers instantiation
$users = new MicroCol();
$tournaments = new MicroCol();
$events = new MicroCol();
$universities = new MicroCol();

// Handlers
$users->setHandler(new \Controllers\UserController());
$tournaments->setHandler(new \Controllers\TournamentController());
$events->setHandler(new \Controllers\EventController());
$universities->setHandler(new \Controllers\UniversityController());

// Setting Route prefixes
$users->setPrefix('/user');
$tournaments->setPrefix('/tournament');
$events->setPrefix('/event');
$universities->setPrefix('/university');

// Users routes
$users->post('/get-by-id', 'getUserById');
$users->post('/get-by-link', 'getUsersByLink');
$users->post('/register','registerNewUser');

//Tournament routes
$tournaments->post('/get-by-id','getTournamentById');
$tournaments->get('/get-all','getAllTournaments');
//$tournaments->post('/add','createNewTournament');

//Event routes
$events->post('/get-by-id','getEventById');
$events->post('/home','getHomepage');
$events->post('/schedule-observer','getScheduleObserver');

//University routes
$universities->post('/add','createNewUniversity');
$universities->get('/get-all','getAllUniversities');

// Mounting controllers
$app->mount($users);
$app->mount($tournaments);
$app->mount($events);
$app->mount($universities);