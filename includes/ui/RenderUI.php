<?php

class RenderUI
{
    public static function headComponents(string $title, string $basePath = './', ?array $css = null, ?array $js = null)
    {
?>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        <?php
        if ($css != null) {
            foreach ($css as $c) {
                echo '<link rel="stylesheet" href="' . $basePath . 'assets/css/' . $c . '"> ';
            }
        }
        if ($js != null) {
            foreach ($js as $j) {
                echo '<script src="' . $basePath . 'assets/js/' . $j . '"></script> ';
            }
        }
        ?>

    <?php
    }

    public static function footer(?array $js = null, string $basePath = './')
    {
    ?>
        <footer>
            <center>
                <p>This website was created for educational purpose. It uses the data of 123MKV. We never promote piracy of copyright content.</p>
                <span><b>Developer:</b> <span>Shubham Gupta</span> | <a target="_blank" class="link" href="https://github.com/shubham-gupta-16">Github</a> | <a target="_blank" class="link" href="https://www.linkedin.com/in/shubham-gupta-16-in/">Linked In</a></span>
                <div style="margin-top: 5px;">Source Code: <a target="_blank" class="link" href="https://github.com/shubham-gupta-16/123MKV-AdFree-Website-JSOUP-PHP">https://github.com/shubham-gupta-16/123MKV-AdFree-Website-JSOUP-PHP</a></div>
            </center>
        </footer>
        <?php
        if ($js != null) {
            foreach ($js as $j) {
                echo '<script src="' . $basePath . 'assets/js/' . $j . '"></script> ';
            }
        }
    }

    public static function navbar(?string $type = null, ?string $value = 'not-fixed')
    {
        $categories = [
            [
                'name' => 'Newly Added',
                'href' => './',
                'active' => $value == null
            ],
            [
                'name' => 'Bollywood',
                'href' => './?category=hindi-movies',
                'active' => $value == 'hindi-movies'
            ],
            [
                'name' => 'Hollywood',
                'href' => './?category=hollywood-movies',
                'active' => $value == 'hollywood-movies'
            ],
            [
                'name' => 'South Indian',
                'href' => './?category=south-movies',
                'active' => $value == 'south-movies'
            ],
        ];
        ?>
        <nav id="toolbar">
            <div class="container">
                <div class="logo">We Are Great Site</div>
                <div class="navigation">
                    <div>
                        <form class="search" action="./" method="GET">
                            <span id="mobile-search-close" class="image-icon back-icon"></span>
                            <input type="text" name="s" placeholder="Search for a movie..." value="<?= $type == 's' ? $value : '' ?>">
                            <button type="submit" class="image-icon search-icon"></button>
                        </form>
                        <button type="submit" id="mobile-search-open" class="image-icon search-icon"></button>
                    </div>
                    <div class="nav-dropdown">
                        <span class="nav-item image-icon selector"></span>
                        <ul class="nav-dropdown-content">
                            <?php
                            foreach ($categories as $nav) {
                            ?>
                                <li>
                                    <a class="nav-item <?= $nav['active'] == true ? 'active' : '' ?>" href="<?= $nav['href'] ?>"><?= $nav['name'] ?></a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <?php
    }

    // small components

    public static function article(array $data)
    {
        ?>
        <a href="./document?uri=<?= $data['uri'] ?>" class="">
            <div class="doc-card">
                <div style="background-image: url(<?= $data['image'] ?>);"></div>
                <header>
                    <div class="d-name"><?= $data['name'] ?></div>
                    <div><?= $data['year'] ?></div>
                </header>
            </div>
        </a>
<?php
    }

    private static function getHref(int $page, $type, $value)
    {
        $href = "?page=" . $page;
        if ($type != null && $value != null) $href = "?$type=" . $value . self::appendPage("&", $page);
        else $href = self::appendPage("?", $page);
        return $href;
    }
    private static function appendPage(string $with, int $page)
    {
        if ($page > 1)
            return $with . "page=" . $page;
        else if ($with == "?")
            return "./";

        return "";
    }
}
