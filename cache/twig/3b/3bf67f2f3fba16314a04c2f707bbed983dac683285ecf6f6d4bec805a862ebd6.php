<?php

/* index.html */
class __TwigTemplate_ed19b501398dcc85a8b77fd3d131059f67b2d61e4e1c4c6671099b700c42d318 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">
<html lang=\"en\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\">
    <title>";
        // line 5
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "</title>
</head>
<body>
";
        // line 8
        echo twig_escape_filter($this->env, ($context["keyword"] ?? null), "html", null, true);
        echo "
<div>";
        // line 9
        echo twig_escape_filter($this->env, ($context["items"] ?? null), "html", null, true);
        echo "</div>
<div>
    <ul>
        ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["testArray"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 13
            echo "        <li>";
            echo twig_escape_filter($this->env, $context["user"], "html", null, true);
            echo "</li>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 15
            echo "        <li><em>no user found</em></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "    </ul>
</div>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 17,  58 => 15,  50 => 13,  45 => 12,  39 => 9,  35 => 8,  29 => 5,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">
<html lang=\"en\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\">
    <title>{{ title }}</title>
</head>
<body>
{{ keyword }}
<div>{{ items }}</div>
<div>
    <ul>
        {% for user in testArray %}
        <li>{{ user }}</li>
        {% else %}
        <li><em>no user found</em></li>
        {% endfor %}
    </ul>
</div>
</body>
</html>", "index.html", "D:\\wamp\\www\\xiaoming\\application\\index\\view\\index.html");
    }
}
