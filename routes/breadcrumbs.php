<?php

Breadcrumbs::register('dashboard', function($breadcrumbs)
{
    $breadcrumbs->push('Dashboard', route('dashboard'));
});

Breadcrumbs::register('campaign.show', function($breadcrumbs, $campaign)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push($campaign->name, route('campaign.show', $campaign->slug));
});

Breadcrumbs::register('campaign.mission.show', function($breadcrumbs, $campaign, $mission)
{
    $breadcrumbs->parent('campaign.show', $campaign);
    $breadcrumbs->push($mission->name, route('campaign.mission.show', [$campaign->slug, $mission->mission_slug]));
});

Breadcrumbs::register('campaign.mission.objective.show', function($breadcrumbs, $campaign, $mission, $objective)
{
    $breadcrumbs->parent('campaign.mission.show', $campaign, $mission);
    $breadcrumbs->push($objective->name, route('campaign.mission.objective.show', [$campaign->slug, $mission->mission_slug, $objective->objective_slug]));
});
