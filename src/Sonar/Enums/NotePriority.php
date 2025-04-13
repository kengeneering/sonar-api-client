<?php

namespace Kengineering\Sonar\Enums;


enum NotePriority: string
{
    case POPUP = 'STICKY_WITH_CONFIRMATION';
    case STICKY = 'STICKY';
    case NORMAL = 'NORMAL';
}