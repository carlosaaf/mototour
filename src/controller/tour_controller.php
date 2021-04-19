<?php

namespace Mototour\Controler;

use Mototour\Controler\PageController;
use Mototour\Model\TourRepository;

class TourController
{
    public static function list($params)
    {
        $id = $params[1];

        $result =  PageController::header()
            . TourController::showHeader('Lista de Passeios')
            . <<<HTML
            <table class="table">
            <thead>
                <tr>
                    <th scope="col" style="width:5%">#</th>
                    <th scope="col" style="width:85%">Nome</th>
                    <th scope="col" style="width:5%"></th>
                    <th scope="col" style="width:5%"><a href="/tours/add" class="btn btn-primary">Incluir</a></th>
                </tr>
            </thead>
            <tbody>
            HTML;

        $repo = new TourRepository();
        $items = $repo->findTours();
        if ($items->num_rows > 0) {
            while ($item = $items->fetch_assoc()) {
                $result .= <<<HTML
                    <tr>
                        <th scope="row">{$item['id']}</th>
                        <td>{$item['name']}</td>
                        <td><a href="/tours/{$item['id']}/edit" class="btn btn-primary">Editar</a></td>
                        <td><a href="/tours/{$item['id']}/delete" class="btn btn-danger">Excluir</a></td>
                    </tr>
                HTML;
            }
        }
        unset($repo);

        $result = $result
            . '</tbody>'
            . '</table>'
            . PageController::footer();

        return $result;
    }

    public static function show($params)
    {
        $result = PageController::header();
        $id = $params[1];
        if (isset($id)) {
            $repo = new TourRepository();
            if ($item = $repo->findTourById($id)) {
                $result .= TourController::showHeader($item['name'])
                    . <<<HTML
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">ID</th>
                                    <td>{$item['id']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nome</th>
                                    <td>{$item['name']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Descrição</th>
                                    <td>{$item['description']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Foto</th>
                                    <td><img src="{$item['photo']}" /></td>
                                </tr>
                            </tbody>
                        </table>
                    HTML;
            } else {
                $result .= <<<HTML
                    <div class="alert alert-danger text-center" role="alert">
                      Passeio não encontrado!
                    </div>
                HTML;
            }
            unset($repo);
        }

        $result .= PageController::footer();

        return $result;
    }

    public static function edit($params)
    {
        $title = "Novo Passeio";
        $id = 0;
        $name = '';
        $description = '';
        $photo = '';
        if (isset($params[1])) {
            $repo = new TourRepository();
            if ($item = $repo->findTourById($params[1])) {
                $title = $item['name'];
                $id = $item['id'];
                $name = $item['name'];
                $description = $item['description'];
                $photo = $item['photo'];
            } else {
                $id = -1;
            }
            unset($repo);
        }

        if ($id == -1) {
            return PageController::header()
                . TourController::showHeader($title)
                . <<<HTML
                    <div class="alert alert-danger text-center" role="alert">
                        Passeio não encontrado!
                    </div>
                HTML
                . PageController::footer();
        }

        return PageController::header()
            . TourController::showHeader($title)
            . <<<HTML
                <form method="POST" action="/tours/save">
                    <input type="hidden" id="id" name="id" value="{$id}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="name" id="name" value="{$name}">
                    </div>
                    <div class="mb-3">
                        <label for="desciption" class="form-label">Descrição</label>
                        <input type="text" class="form-control" name="description" id="description" value="{$description}">
                        </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto</label>
                        <input type="text" class="form-control" name="photo" id="photo" value="{$photo}">
                        </div>
                    <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Salvar">
                    <a href="/tours" class="btn btn-primary">Voltar</a>
                </form>
            HTML
            . PageController::footer();
    }

    public static function save($params)
    {
        $body = array_values($_POST);
        $id = $body[0];
        $name = $body[1];
        $description = $body[2];
        $photo = $body[3];
        $title = "Salvando o passeio";

        $repo = new TourRepository();
        $result = $repo->saveTour($id, $name, $description, $photo);
        unset($repo);

        if (!$result) {
            return PageController::header()
                . TourController::showHeader($title)
                . <<<HTML
                    <div class="alert alert-danger text-center" role="alert">
                        Erro ao salvar o passeio!
                    </div>
                    <p><a href="/tours" class="btn btn-primary">Voltar<a/></p>
                HTML
                . PageController::footer();
        }
        return PageController::header()
            . TourController::showHeader($name)
            . <<<HTML
                <p>Passeio salvo</p>
                <p><a href="/tours/{$result}/edit" class="btn btn-primary">Voltar<a/></p>
            HTML
            . PageController::footer();
    }

    public static function delete($params)
    {
        $id = $params[1];
        $result = PageController::header()
            . TourController::showHeader('Exclusão de Passeio')
            . <<<HTML
                <p>Passeio excluído</p>
                <p><a href="/tours" class="btn btn-primary">Voltar<a/></p>
            HTML
            . PageController::footer();

        return $result;
    }

    private static function showHeader($title) {
        return <<<HTML
            <header class="jumbotron bg-primary text-white text-center">
                <h1 class="display-2">{$title}</h1>
            </header>
        HTML;
    }
}