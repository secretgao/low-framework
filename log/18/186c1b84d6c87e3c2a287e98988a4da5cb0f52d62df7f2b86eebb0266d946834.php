<?php

/* layout.html */
class __TwigTemplate_bb49e01bfb39565107d4e766898d86ae1f184da34c45e80d1431e9093c9babcf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
<meta charset=\"UTF-8\">
<title>Insert title here</title>
</head>
<header> header</header>
<body>
   <content>
   \t";
        // line 10
        $this->displayBlock('content', $context, $blocks);
        // line 12
        echo "   
   </content>

</body>
<footer> footer </footer>
</html>";
    }

    // line 10
    public function block_content($context, array $blocks = array())
    {
        // line 11
        echo "    ";
    }

    public function getTemplateName()
    {
        return "layout.html";
    }

    public function getDebugInfo()
    {
        return array (  45 => 11,  42 => 10,  33 => 12,  31 => 10,  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
<meta charset=\"UTF-8\">
<title>Insert title here</title>
</head>
<header> header</header>
<body>
   <content>
   \t{% block content %}
    {% endblock content %}
   
   </content>

</body>
<footer> footer </footer>
</html>", "layout.html", "D:\\work\\sycalc\\app\\views\\index\\layout.html");
    }
}
