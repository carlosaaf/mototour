<?php

namespace Mototour\Controler;

use Mototour\Controler\PageController;
use Mototour\Model\TourRepository;

class HomeController
{
    public static function hello($params)
    {
        return PageController::header()
            . HomeController::showHeader()
            . HomeController::showCards()
            . PageController::footer();
    }

    private static function showHeader()
    {
        return <<<HTML
            <header class="jumbotron bg-primary text-white text-center">
                <img class="img-fluid bg-primary" width="300px" style="margin-top:16px" src="/img/rider.png" />
                <h1 class="display-2">Bem-vindo!</h1>
            </header>
        HTML;
    }

    private static function showCards()
    {
        $repo = new TourRepository();
        $tours = $repo->findTours();
        $result = '<div class="row text-center">';
        while ($tour = $tours->fetch_assoc()) {
            $result .= <<<HTML
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="/tours/{$tour['id']}">
                        <div class="card h-100">
                            <img class="card-img-top" width="900px" src="{$tour['photo']}" alt="">
                            <div class="card-body">
                                <h4 class="card-title">{$tour['name']}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            HTML;
        }    
        unset($repo); 
        $result .= '</div>';
        return $result;
    }
}