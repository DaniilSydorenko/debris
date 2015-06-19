<?php

/* templates/base.twig */
class __TwigTemplate_a0ab895f3379278645f01c440c208a3fb833439e548b9929d508f272df7fde95 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'header' => array($this, 'block_header'),
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $this->displayBlock('header', $context, $blocks);
        // line 146
        echo "
";
        // line 148
        echo "<body class=\"";
        echo twig_escape_filter($this->env, (isset($context["bodyClass"]) ? $context["bodyClass"] : null), "html", null, true);
        echo "\">

";
        // line 150
        $this->env->loadTemplate("elements/header.twig")->display($context);
        // line 151
        echo "
";
        // line 153
        $this->displayBlock('content', $context, $blocks);
        // line 154
        echo "
";
        // line 156
        $this->displayBlock('footer', $context, $blocks);
    }

    // line 2
    public function block_header($context, array $blocks = array())
    {
        // line 3
        echo "    <!--[if lt IE 7]>
    <html lang=\"en-US\" prefix=\"og: http://ogp.me/ns#\" class=\"no-js lt-ie9 lt-ie8 lt-ie7\">
    <![endif]-->
    <!--[if (IE 7)&(!IEMobile)]>
    <html lang=\"en-US\" prefix=\"og: http://ogp.me/ns#\" class=\"no-js lt-ie9 lt-ie8\">
    <![endif]-->
    <!--[if (IE 8)&(!IEMobile)]>
    <html lang=\"en-US\" prefix=\"og: http://ogp.me/ns#\" class=\"no-js lt-ie9\">
    <![endif]-->
    <!--[if gt IE 8]><!-->
<html lang=\"en-US\" prefix=\"og: http://ogp.me/ns#\" class=\"no-js\">
<!--<![endif]-->
<!DOCTYPE html>
<html>
";
        // line 18
        echo "<head ";
        $this->displayBlock('head', $context, $blocks);
        echo ">
    <meta charset=\"UTF-8\"/>
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

    ";
        // line 23
        if (((isset($context["bodyClass"]) ? $context["bodyClass"] : null) == "url-snr")) {
            // line 24
            echo "        <meta name=\"description\"
              content=\"Debris Tools: Url Shortener helps you to make beautiful short url from endless string and share it for redirection to another site. Short long urls. Make url shorter.\">
        <meta name=\"keywords\" content=\"url shortener, url shorteners, small url, short url, url, link, short\">

        <!-- Schema.org markup for Google+ -->
        <meta itemprop=\"name\" content=\"Debris | Url Shortener\">
        <meta itemprop=\"description\"
              content=\"Debris Url Shortener helps you to make beautiful short url from endless string and share it for redirection to another site.\">
        <meta itemprop=\"image\" content=\"http://debrs.com/img/icons/favicon_sign.ico\">

        <!-- Twitter Card data -->
        <meta name=\"twitter:card\" content=\"summary\">
        <meta name=\"twitter:site\" content=\"@publisher_handle\">
        <meta name=\"twitter:title\" content=\"Debris | Url Shortener\">
        <meta name=\"twitter:description\"
              content=\"Debris Url Shortener helps you to make beautiful short url from endless string and share it for redirection to another site.\">
        <meta name=\"twitter:creator\" content=\"@dansydorenko\">
        <meta name=\"twitter:image\" content=\"http://debrs.com/img/icons/favicon_sign.ico\">

        <!-- Open Graph data -->
        <meta property=\"og:title\" content=\"Debris | Url Shortener\"/>
        <meta property=\"og:url\" content=\"http://debrs.com/\"/>
        <meta property=\"og:image\" content=\"http://debrs.com/img/icons/favicon_sign.ico\"/>
        <meta property=\"og:description\"
              content=\"Debris Url Shortener helps you to make beautiful short url from endless string and share it for redirection to another site.\"/>
        <meta property=\"og:site_name\" content=\"Debris\"/>
    ";
        } elseif ((        // line 50
(isset($context["bodyClass"]) ? $context["bodyClass"] : null) == "file-psr")) {
            // line 51
            echo "        <meta name=\"description\" content=\"File Parser\">
        <meta name=\"keywords\" content=\"File Parser\">

        ";
            // line 55
            echo "        ";
            // line 56
            echo "        ";
            // line 57
            echo "        ";
            // line 58
            echo "
        ";
            // line 60
            echo "        ";
            // line 61
            echo "        ";
            // line 62
            echo "        ";
            // line 63
            echo "        ";
            // line 64
            echo "        ";
            // line 65
            echo "        ";
            // line 66
            echo "

        ";
            // line 69
            echo "        ";
            // line 70
            echo "        ";
            // line 71
            echo "        ";
            // line 72
            echo "        ";
            // line 73
            echo "        ";
            // line 74
            echo "    ";
        } else {
            // line 75
            echo "        <meta name=\"description\" content=\"Sitemap Generator\">
        <meta name=\"keywords\" content=\"Sitemap Generator\">

        ";
            // line 79
            echo "        ";
            // line 80
            echo "        ";
            // line 81
            echo "        ";
            // line 82
            echo "
        ";
            // line 84
            echo "        ";
            // line 85
            echo "        ";
            // line 86
            echo "        ";
            // line 87
            echo "        ";
            // line 88
            echo "        ";
            // line 89
            echo "        ";
            // line 90
            echo "

        ";
            // line 93
            echo "        ";
            // line 94
            echo "        ";
            // line 95
            echo "        ";
            // line 96
            echo "        ";
            // line 97
            echo "        ";
            // line 98
            echo "    ";
        }
        // line 99
        echo "
    ";
        // line 101
        echo "    <title>Debris | ";
        $this->displayBlock('title', $context, $blocks);
        echo "</title>

    <!-- Styles -->
    <link rel=\"shortcut icon\" href=\"/img/icons/favicon_sign.ico\">
    <link rel=\"stylesheet\" href=\"//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css\">

    ";
        // line 108
        echo "    <link rel=\"stylesheet\" href=\"/css/main.css\" type=\"text/css\">

    ";
        // line 111
        echo "    <link href=\"/css/normalize.css\" rel=\"stylesheet\" type=\"text/css\">
    <link href=\"/css/animate.css\" rel=\"stylesheet\" type=\"text/css\">
    <link href=\"/bootstrap/dist/css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\">
    <link href=\"/fontawesome/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\">

    ";
        // line 117
        echo "    <script src=\"/jquery/dist/jquery.min.js\" type=\"text/javascript\"></script>

    ";
        // line 120
        echo "    <script src=\"/js/main.js\" type=\"text/javascript\"></script>

    ";
        // line 123
        echo "    <script src=\"//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5504b827792c00c7\" type=\"text/javascript\"
            async=\"async\"></script>

    <!-- Google Analytics -->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-49168124-2', 'auto');
        ga('send', 'pageview');
    </script>
</head>

";
    }

    // line 18
    public function block_head($context, array $blocks = array())
    {
    }

    // line 101
    public function block_title($context, array $blocks = array())
    {
    }

    // line 153
    public function block_content($context, array $blocks = array())
    {
    }

    // line 156
    public function block_footer($context, array $blocks = array())
    {
        // line 157
        echo "
";
        // line 159
        $this->env->loadTemplate("elements/footer.twig")->display($context);
        // line 160
        echo "
";
    }

    public function getTemplateName()
    {
        return "templates/base.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  276 => 160,  274 => 159,  271 => 157,  268 => 156,  263 => 153,  258 => 101,  253 => 18,  227 => 123,  223 => 120,  219 => 117,  212 => 111,  208 => 108,  198 => 101,  195 => 99,  192 => 98,  190 => 97,  188 => 96,  186 => 95,  184 => 94,  182 => 93,  178 => 90,  176 => 89,  174 => 88,  172 => 87,  170 => 86,  168 => 85,  166 => 84,  163 => 82,  161 => 81,  159 => 80,  157 => 79,  152 => 75,  149 => 74,  147 => 73,  145 => 72,  143 => 71,  141 => 70,  139 => 69,  135 => 66,  133 => 65,  131 => 64,  129 => 63,  127 => 62,  125 => 61,  123 => 60,  120 => 58,  118 => 57,  116 => 56,  114 => 55,  109 => 51,  107 => 50,  79 => 24,  77 => 23,  68 => 18,  52 => 3,  49 => 2,  45 => 156,  42 => 154,  40 => 153,  37 => 151,  35 => 150,  29 => 148,  26 => 146,  24 => 2,);
    }
}
