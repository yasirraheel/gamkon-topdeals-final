<?php

namespace App\Enums;

enum NavigationType: string
{
    case Header = 'header';
    case FooterWidget1 = 'footer-widget-1';
    case FooterWidget2 = 'footer-widget-2';
    case FooterWidget3 = 'footer-widget-3';
    case FooterWidgetBottom = 'footer-widget-bottom';
}
