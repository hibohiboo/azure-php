<?php

use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;


require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set('upload_directory', __DIR__ . '/uploads');

AppFactory::setContainer($container);
$app = AppFactory::create();

// Create Twig
$twig = Twig::create('../templates', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/hello', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});



$app->post('/roomUpload/{uid}/{roomId}',function (Request $request, Response $response,$args) {
    $directory = $this->get('upload_directory');
    $uid = $args['uid'];
    $roomId = $args['roomId'];
    $uploadedFiles = $request->getUploadedFiles();
    // handle single input with single file upload
    $uploadedFile = $uploadedFiles['demo'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $filename = moveUploadedFile($directory, $uid, $roomId, $uploadedFile);
        $data = array('filename' => $filename);
        $payload = json_encode($data);
        $response->getBody()->write($payload);
    }
    return $response->withHeader('Content-Type', 'application/json');
});


/**
 * Moves the uploaded file to the upload directory and assigns it a unique name
 * to avoid overwriting an existing uploaded file.
 *
 * @param string $directory The directory to which the file is moved
 * @param UploadedFileInterface $uploadedFile The file uploaded file to move
 *
 * @return string The filename of moved file
 */
function moveUploadedFile(string $directory, string $subDirectory, string $basename, UploadedFileInterface $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

    // see http://php.net/manual/en/function.random-bytes.php
    // $basename = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    $targetDirectory = $directory .DIRECTORY_SEPARATOR . $subDirectory;
    mkdir($targetDirectory, 0666, true);
    $uploadedFile->moveTo($targetDirectory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}

$app->get('/', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'index.html', [
        'name' => 'test name'
    ]);
});


$app->run();