<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* deal/index.html.twig */
class __TwigTemplate_434a079539a860d61209dd76de34069d86051a371de4b982ed8aaddc289bbef1 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "deal/index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "deal/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "deal/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "Hello DealsController!";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "        <div class=\"container\">
            ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["deals"]) || array_key_exists("deals", $context) ? $context["deals"] : (function () { throw new RuntimeError('Variable "deals" does not exist.', 7, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["deal"]) {
            // line 8
            echo "                ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["deal"], "getIsForSale", [], "any", false, false, false, 8), true))) {
                // line 9
                echo "                    <section>
                        <div class=\"box\">
                            <div class=\"img\">
                                ";
                // line 12
                if (twig_get_attribute($this->env, $this->source, $context["deal"], "shouldShowDiscount", [], "any", false, false, false, 12)) {
                    // line 13
                    echo "                                    <div class=\"red-ribbon\">
                                        <span>
                                            <div class=\"discount_amount\">";
                    // line 15
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["deal"], "getPercentDiscount", [], "any", false, false, false, 15), "html", null, true);
                    echo "%</div>
                                        </span>
                                    </div>
                                ";
                }
                // line 19
                echo "                                <img src=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["deal"], "getFullImg", [], "any", false, false, false, 19), "html", null, true);
                echo "\" alt=\"Deal afbeelding\"/>
                                ";
                // line 20
                echo twig_get_attribute($this->env, $this->source, $context["deal"], "divIsNew", [], "any", false, false, false, 20);
                echo "
                            </div>
                            <div class=\"title\">";
                // line 22
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["deal"], "getTitle", [], "any", false, false, false, 22), "html", null, true);
                echo "</div>
                            <div class=\"company\">";
                // line 23
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["deal"], "company", [], "any", false, false, false, 23), "name", [], "any", false, false, false, 23), "html", null, true);
                echo "</div>
                            <div class=\"sold\">Verkocht: ";
                // line 24
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["deal"], "getSold", [], "any", false, false, false, 24), "html", null, true);
                echo "</div>
                            <div class=\"from\">";
                // line 25
                echo twig_get_attribute($this->env, $this->source, $context["deal"], "getFromPrice", [], "any", false, false, false, 25);
                echo "</div>
                            <div class=\"price\">";
                // line 26
                echo twig_get_attribute($this->env, $this->source, $context["deal"], "getPriceAsHtml", [], "any", false, false, false, 26);
                echo "</div>
                        </div>
                    </section>
                ";
            }
            // line 30
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['deal'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "        </div>
        <div class=\"navigation\">
            ";
        // line 33
        echo $this->extensions['Knp\Bundle\PaginatorBundle\Twig\Extension\PaginationExtension']->render($this->env, (isset($context["deals"]) || array_key_exists("deals", $context) ? $context["deals"] : (function () { throw new RuntimeError('Variable "deals" does not exist.', 33, $this->source); })()));
        echo "
        </div>
    ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "deal/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  159 => 33,  155 => 31,  149 => 30,  142 => 26,  138 => 25,  134 => 24,  130 => 23,  126 => 22,  121 => 20,  116 => 19,  109 => 15,  105 => 13,  103 => 12,  98 => 9,  95 => 8,  91 => 7,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

    {% block title %}Hello DealsController!{% endblock %}

    {% block body %}
        <div class=\"container\">
            {% for deal in deals %}
                {% if deal.getIsForSale == true %}
                    <section>
                        <div class=\"box\">
                            <div class=\"img\">
                                {% if deal.shouldShowDiscount %}
                                    <div class=\"red-ribbon\">
                                        <span>
                                            <div class=\"discount_amount\">{{ deal.getPercentDiscount }}%</div>
                                        </span>
                                    </div>
                                {% endif %}
                                <img src=\"{{ deal.getFullImg }}\" alt=\"Deal afbeelding\"/>
                                {{ deal.divIsNew|raw }}
                            </div>
                            <div class=\"title\">{{ deal.getTitle }}</div>
                            <div class=\"company\">{{ deal.company.name }}</div>
                            <div class=\"sold\">Verkocht: {{ deal.getSold }}</div>
                            <div class=\"from\">{{ deal.getFromPrice|raw }}</div>
                            <div class=\"price\">{{ deal.getPriceAsHtml|raw }}</div>
                        </div>
                    </section>
                {% endif %}
            {% endfor %}
        </div>
        <div class=\"navigation\">
            {{ knp_pagination_render(deals) }}
        </div>
    {% endblock %}

", "deal/index.html.twig", "/var/www/html/casus/templates/deal/index.html.twig");
    }
}
