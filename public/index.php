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

$app->get('/room/{uid}/{roomId}', function ($request, $response, $args) {
    $uid = $args['uid'];
    $roomId = $args['roomId'];
    $view = Twig::fromRequest($request);
    return $view->render($response, 'index.html', [
        'uid' => $uid,
        'roomId'=>$roomId
    ]);
});

$app->post('/roomUpload/{uid}/{roomId}',function (Request $request, Response $response,$args) {
    $directory = $this->get('upload_directory');
    $uid = $args['uid'];
    $roomId = $args['roomId'];
    $uploadedFiles = $request->getUploadedFiles();
    // handle single input with single file upload
    $formName = 'demo';
    $uploadedFile = $uploadedFiles[$formName];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        // 画像ファイル以外は保存しない
        if (checkImageType($_FILES[$formName]['tmp_name']) == '') {
            throw new Exception('期待しないファイルタイプ');
        }
        // 10M以上の画像ファイルは保存しない
        if($uploadedFile->getSize() > 10485760) {
            throw new Exception('大きすぎるファイル');
        }
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

function checkImageType($filename)
{
    // const getMimetype = (signature) => {
//     switch (signature) {
//       case '89504E47':
//         return 'image/png'
//       case '47494638':
//         return 'image/gif'
//       case '25504446':
//         return 'application/pdf'
//       case 'FFD8FFDB':
//       case 'FFD8FFE0':
//       case 'FFD8FFE1':
//         return 'image/jpeg'
//       case '504B0304':
//         return 'application/zip'
//       default:
//         return 'Unknown filetype'
//     }
//   }
	//先頭数文字を取得する.巨大なファイルでも先頭だけ見る.
	$magic = file_get_contents($filename, false, null, 0, 12);

	$type = '';
	if (strpos($magic, 'GIF') === 0) {
		//GIF87a,GIF89a
		$type = 'GIF';
	} else if (strpos($magic, "\x89" . 'PNG') === 0) {
		$type = 'PNG';
	} else if (strpos($magic, "\xFF\xD8") === 0) {
		//FF D8 DD E0 or FF D8 FF EE
		$type = 'JPG';
	} else if (strpos($magic, "BM") === 0) {
		$type = 'BMP';
	} else if (strpos($magic, "\x25\x21") === 0) {
		$type = 'EPS';
	} else if (strpos($magic, "%PDF-1") === 0) {
		//%PDF-1.3, %PDF-1.4 ...
		$type = 'PDF';
	}

	return $type;
}


$app->get('/', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'index.html', [
        'uid' => 'Vj7ovQpJVURWbOC2Nu2rUDaibxI2',
        'roomId'=>'UIi7BhN4dqC8G5B1ec0B'
    ]);
});




$app->run();