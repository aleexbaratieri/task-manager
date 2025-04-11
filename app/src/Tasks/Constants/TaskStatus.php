<?php

namespace Src\Tasks\Constants;

enum TaskStatus: string
{
    case OPEN = 'OPEN';
    case IN_PROGRESS = 'IN_PROGRESS';
    case COMPLETED = 'COMPLETED';
    case REJECTED = 'REJECTED';
}
