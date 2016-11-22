<?php

$app->get('/', function ($request, $response) use($app) {
    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = "user";
    }

    return $this->view->render($response, 'index.html', array(
        'user' => $_SESSION['user']
    ));
});

$app->get('/salir', function ($request, $response) use($app) {
    $_SESSION['user'] = 'user';
    return $response->withStatus(302)->withHeader('Location', '/');
});

$app->get('/login', function ($request, $response) use($app) {
    if ($_SESSION['user'] === "admin") {
        return $response->withStatus(302)->withHeader('Location', '/admin');
    }

    return $this->view->render($response, 'login.html', array(
        'user' => $_SESSION['user']
    ));
});

$app->post('/login', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "admin") {
        return $response->withStatus(302)->withHeader('Location', '/');
    }

    $user = $request->getParsedBody()['usuario'];
    $pass = $request->getParsedBody()['password'];
    $row_user = $database->admin()[0]['user'];
    $row_password = $database->admin()[0]['password'];

    if ($user === $row_user && $pass === $row_password) {
        $_SESSION['user'] = "admin";
        return $response->withStatus(302)->withHeader('Location', '/');
    }

    return $response->withStatus(302)->withHeader('Location', '/login');
});

$app->get('/admin', function ($request, $response) use($app) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    return $this->view->render($response, 'admin.html', array(
        'user' => $_SESSION['user']
    ));
});

$app->get('/alumnos', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $alumnos = $database->alumnos();

    return $this->view->render($response, 'alumnos.html', array(
        'user' => $_SESSION['user'],
        'alumnos' => $alumnos
    ));
});

$app->get('/nuevoalumno', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    return $this->view->render($response, 'nuevoalumno.html', array(
        'user' => $_SESSION['user'],
    ));
});

$app->post('/nuevoalumno', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $res = $database->alumnos()->insert(array(
        "dni" => $request->getParsedBody()['dni'],
        "apellido" => $request->getParsedBody()['apellido'],
        "nombre" => $request->getParsedBody()['nombre'],
        "telefono" => $request->getParsedBody()['telefono'],
        "mail" => $request->getParsedBody()['mail'],
    ));

    return $response->withStatus(302)->withHeader('Location', '/alumnos');
});

$app->get('/alumno/eliminar/{dni}', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $dni = $request->getAttribute('dni');
    $res = $database->alumnos[$dni]->delete();

    return $response->withStatus(302)->withHeader('Location', '/alumnos');
});

$app->get('/alumno/modificar/{dni}', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $dni = $request->getAttribute('dni');
    $alumno = $database->alumnos[$dni];
    
    return $this->view->render($response, 'modificaralumno.html', array(
        'user' => $_SESSION['user'],
        'alumno' => $alumno
    ));
});

$app->post('/alumno/modificar', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $res = $database->alumnos()->insert_update(array(), array(
        "dni" => $request->getParsedBody()['dni'],
        "apellido" => $request->getParsedBody()['apellido'],
        "nombre" => $request->getParsedBody()['nombre'],
        "telefono" => $request->getParsedBody()['telefono'],
        "mail" => $request->getParsedBody()['mail'],
    ), array());

    return $response->withStatus(302)->withHeader('Location', '/alumnos');
});

$app->get('/profesores', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $profesores = $database->profesores();

    return $this->view->render($response, 'profesores.html', array(
        'user' => $_SESSION['user'],
        'profesores' => $profesores
    ));
});

$app->get('/profesor/nuevo', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    return $this->view->render($response, 'nuevoprofesor.html', array(
        'user' => $_SESSION['user'],
    ));
});

$app->post('/profesor/nuevo', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $res = $database->profesores()->insert(array(
        "dni" => $request->getParsedBody()['dni'],
        "apellido" => $request->getParsedBody()['apellido'],
        "nombre" => $request->getParsedBody()['nombre'],
        "telefono" => $request->getParsedBody()['telefono'],
        "mail" => $request->getParsedBody()['mail'],
        "observaciones" => $request->getParsedBody()['observaciones'],
    ));

    return $response->withStatus(302)->withHeader('Location', '/profesores');
});

$app->get('/profesor/eliminar/{dni}', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $dni = $request->getAttribute('dni');
    $res = $database->profesores[$dni]->delete();

    return $response->withStatus(302)->withHeader('Location', '/profesores');
});

$app->get('/profesor/modificar/{dni}', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $dni = $request->getAttribute('dni');
    $profesor = $database->profesores[$dni];
    
    return $this->view->render($response, 'modificarprofesor.html', array(
        'user' => $_SESSION['user'],
        'profesor' => $profesor
    ));
});

$app->post('/profesor/modificar', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $res = $database->profesores()->insert_update(array(), array(
        "dni" => $request->getParsedBody()['dni'],
        "apellido" => $request->getParsedBody()['apellido'],
        "nombre" => $request->getParsedBody()['nombre'],
        "telefono" => $request->getParsedBody()['telefono'],
        "mail" => $request->getParsedBody()['mail'],
        "observaciones" => $request->getParsedBody()['observaciones'],
    ), array());

    return $response->withStatus(302)->withHeader('Location', '/profesores');
});

$app->get('/cursos', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $cursos = $database->cursos();

    return $this->view->render($response, 'cursos.html', array(
        'user' => $_SESSION['user'],
        'cursos' => $cursos
    ));
});

$app->get('/curso/nuevo', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $profesores = $database->profesores();

    return $this->view->render($response, 'nuevocurso.html', array(
        'user' => $_SESSION['user'],
        'profesores' => $profesores
    ));
});

$app->post('/curso/nuevo', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $res = $database->cursos()->insert(array(
        "nombre" => $request->getParsedBody()['nombre'],
        "profesor" => $request->getParsedBody()['profesor'],
        "puntaje" => $request->getParsedBody()['puntaje'],
        "inicio" => $request->getParsedBody()['inicio'],
        "horario" => $request->getParsedBody()['horario'],
        "observaciones" => $request->getParsedBody()['observaciones'],
        "disponible" => true
    ));

    return $response->withStatus(302)->withHeader('Location', '/cursos');
});

$app->get('/curso/eliminar/{id}', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $id = $request->getAttribute('id');
    $res = $database->cursos[$id]->delete();

    return $response->withStatus(302)->withHeader('Location', '/cursos');
});

$app->get('/curso/modificar/{id}', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $id = $request->getAttribute('id');
    $curso = $database->cursos[$id];

    $profesores = $database->profesores();
    
    return $this->view->render($response, 'modificarcurso.html', array(
        'user' => $_SESSION['user'],
        'curso' => $curso,
        'profesores' => $profesores
    ));
});

$app->post('/curso/modificar', function ($request, $response) use($app, $database) {
    if ($_SESSION['user'] === "user") {
        return $response->withStatus(302)->withHeader('Location', '/login');
    }

    $res = $database->cursos()->insert_update(array(), array(
        "nombre" => $request->getParsedBody()['nombre'],
        "profesor" => $request->getParsedBody()['profesor'],
        "puntaje" => $request->getParsedBody()['puntaje'],
        "inicio" => $request->getParsedBody()['inicio'],
        "horario" => $request->getParsedBody()['horario'],
        "observaciones" => $request->getParsedBody()['observaciones'],
        "disponible" => true
    ), array());

    return $response->withStatus(302)->withHeader('Location', '/cursos');
});

?>