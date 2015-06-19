<?php

/* shortener/index.twig */
class __TwigTemplate_a4580cd9161777ce4c301c8711834bd07306b6e9acd49ea5f0e56ea79abcf146 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 2
        try {
            $this->parent = $this->env->loadTemplate("templates/base.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(2);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "templates/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 8
        $context["bodyClass"] = "url-snr";
        // line 2
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "data", array()), "title", array()), "html", null, true);
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "    <!-- BEGIN Service title -->
    <div class=\"row\">
        <div class=\"col-md-10 col-sm-10 col-xs-12 center-block animated slideInLeft\">
            <div class=\"url-snr-public-text\">
                <h4>Debris | ";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "data", array()), "title", array()), "html", null, true);
        echo "</h4>
            </div>
        </div>
    </div>
    <!-- END Service title -->
    <!-- BEGIN Main area -->
    <div class=\"row\">
        <div class=\"col-md-10 col-sm-10 col-xs-12 center-block\">
            <!-- BEGIN Form -->
            <form action=\"/\" method=\"post\" class=\"form-horizontal url-snr-form\">
                <i class=\"fa fa-link\"></i>
                <div id=\"urlfield\">
                    <div>
                        <label class=\"hidden required\" for=\"urlfield_url\">Url</label>
                        <input type=\"text\" id=\"urlfield_url\" name=\"urlfield[url]\" required=\"required\" class=\"form-control\" placeholder=\"Enter your long URL\">
                    </div>
                    <div>
                        <button type=\"submit\" id=\"urlfield_Shorten\" name=\"urlfield[Shorten]\" class=\"center-block-btn\">Shorten</button>
                    </div>
                </div>
            </form>
            <!-- END Form -->
            ";
        // line 39
        echo "            ";
        // line 40
        echo "            ";
        // line 41
        echo "            <!-- BEGIN Result box -->
            <section class=\"url-snr-box\" style=\"display: none\">
                <div class=\"row\">
                    <div class=\"url-snr-url-valid\">
                        <div class=\"url-snr-box-srt col-md-5 col-sm-6 pull-left\">
                            <h4 class=\"url-snr-header\">Shorten URL</h4>
                            <div class=\"url-snr-box-content\">
                                <i class=\"fa fa-link\"></i>
                                <input type=\"text\" class=\"form-control url-snr-short-url\" style=\"text-align: center\">
                            </div>
                        </div>
                        <div class=\"url-snr-box-lng col-md-5 col-sm-6 pull-right\">
                            <h4 class=\"url-snr-header\">Original URL</h4>

                            <div class=\"url-snr-box-content\">
                                <i class=\"fa fa-link\"></i>
                                <input type=\"text\" class=\"form-control url-snr-long-url\" style=\"text-align: center\">
                            </div>
                        </div>
                        <div class=\"url-snr-box-share col-md-12 col-sm-12\">
                            <div class=\"url-snr-box-statistic\" style=\"display: none\">
                                <label for=\"url-statistic\"></label>
                                <p id=\"url-statistic\"></p>
                            </div>
                            <label class=\"url-snr-label\" for=\"url-snr-share-tools\">Share with firends:</label>
                            <div id=\"url-snr-share-tools footer-social-links\" class=\"addthis_sharing_toolbox\"
                                 data-url=\"http://debrs.com/\" data-title=\"Debris | URL Shortener\">
                                <div id=\"atstbx\"
                                     class=\"at-share-tbx-element addthis_20x20_style addthis-smartlayers addthis-animated at4-show\">
                                    <a class=\"at-share-btn at-svc-twitter\"><span class=\"at4-icon aticon-twitter\"
                                                                                 title=\"Twitter\"></span></a><a
                                            class=\"at-share-btn at-svc-facebook\"><span class=\"at4-icon aticon-facebook\"
                                                                                       title=\"Facebook\"></span></a><a
                                            class=\"at-share-btn at-svc-google_plusone_share\"><span
                                                class=\"at4-icon aticon-google_plusone_share\" title=\"Google+\"></span></a><a
                                            class=\"at-share-btn at-svc-linkedin\"><span class=\"at4-icon aticon-linkedin\"
                                                                                       title=\"LinkedIn\"></span></a><a
                                            class=\"at-share-btn at-svc-vk\"><span class=\"at4-icon aticon-vk\"
                                                                                 title=\"VKontakte\"></span></a></div>
                            </div>
                        </div>
                    </div>

                    <div class=\"col-md-12 col-sm-12 url-snr-url-invalid\">
                        <label for=\"url-snr-sad-img\"></label>
                        <div id=\"url-snr-sad-img\">
                            <img src=\"/img/icons/sad-face-128.png\" alt=\"Image\" width=\"128\" height=\"128\">
                        </div>
                    </div>
                </div>
            </section>
            <!-- END Result box -->
        </div>
    </div>
    <!-- End Main area -->
";
    }

    public function getTemplateName()
    {
        return "shortener/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 41,  82 => 40,  80 => 39,  55 => 16,  49 => 12,  46 => 11,  40 => 5,  36 => 2,  34 => 8,  11 => 2,);
    }
}
