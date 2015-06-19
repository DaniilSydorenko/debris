<?php

/* elements/footer.twig */
class __TwigTemplate_b7020602ac82034986780662e08dca6a7927ccd31ac90ba7bc65dbdccd0ef0cc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "            ";
        // line 2
        echo "            </section>
            <!-- END Main content -->
            <!-- BEGIN Footer -->
            <footer class=\"footer\">
                <div class=\"container\">
                    <p class=\"text-muted\"><a href=\"https://about.me/dsydorenko\" target=\"_blank\" title=\"By Daniil Sydorenko\">By Daniil Sydorenko</a> &copy;";
        // line 7
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo "</p>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END page content -->

        <!-- JavaScript
        ================================================== -->
        <script src=\"/js/vendor/modernizr.custom.js\" type=\"text/javascript\"></script>
        <script src=\"/js/vendor/bootstrap.filestyle.min.js\" type=\"text/javascript\"></script>
        <script src=\"/bootstrap/dist/js/bootstrap.min.js\" type=\"text/javascript\"></script>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "elements/footer.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 7,  21 => 2,  19 => 1,);
    }
}
