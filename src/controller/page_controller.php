<?php

namespace Mototour\Controler;

class PageController
{
    public static function header()
    {
        return <<<HTML
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="/">Moto Tour</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Início</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="/tours">Passeios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./riders">Amigos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/motorcycles">Motocicletas</a>
                        </li>
                    </ul>
                </div>
            </nav>
        HTML;
    }

    public static function footer()
    {
        return <<<HTML
            <footer class="text-center">
            <p>Seminário Interdisciplinar V - Uniasselvi</p>
            </footer>
        HTML;
    }
}