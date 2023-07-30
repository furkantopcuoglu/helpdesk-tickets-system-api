<?php

namespace Common\Application\Traits;

use Cocur\Slugify\Slugify;

trait SlugifyTrait
{
    protected ?Slugify $slugify = null;

    public function filterSlug($text): string
    {
        if (!($this->slugify instanceof Slugify)) {
            $this->slugify = new Slugify(['rulesets' => ['default', 'turkish']]);
            $this->slugify->activateRuleSet('turkish');
        }

        return $this->slugify->slugify($text);
    }
}
