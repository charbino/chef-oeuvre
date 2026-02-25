<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPreparedSets(symfonyCodeQuality: true)
    ->withComposerBased(symfony: true);
