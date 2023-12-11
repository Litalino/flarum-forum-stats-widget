<?php

/*
 * This file is part of afrux/forum-stats-widget.
 *
 * Copyright (c) 2021 Sami Mazouz.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Litalino\ForumStats;

use Afrux\ForumWidgets\SafeCacheRepositoryAdapter;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Discussion\Discussion;
use Flarum\Post\CommentPost;
use Flarum\User\User;
use Symfony\Contracts\Translation\TranslatorInterface;
use function Afrux\ForumWidgets\Helper\pretty_number_format;

use Flarum\Tags\Tag;
use V17Development\FlarumBlog\BlogMeta\BlogMeta;
use Flarum\Group\Group;

use Illuminate\Session\FileSessionHandler;
use SessionHandlerInterface;
use Symfony\Component\Finder\Finder;

use Carbon\Carbon;

class AddStatsToApi
{
    /**
     * @var SafeCacheRepositoryAdapter
     */
    private $cache;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    protected $sessionHandler;
    protected $onlineDurationMinutes = 5;
    protected $cacheDurationSeconds = 60;

    public function __construct(SessionHandlerInterface $sessionHandler, SafeCacheRepositoryAdapter $cache, TranslatorInterface $translator)
    {
        $this->sessionHandler = $sessionHandler;
        $this->cache = $cache;
        $this->translator = $translator;
    }

    public function __invoke(ForumSerializer $serializer): array
    {
        $interval = 600;
        //java
        //const users = app.store.all('users').filter(u => u.isOnline());
        //const total = users.length;

        $stats = $this->cache->remember('litalino-flarum-forum-stats-widget.stats', $interval, function (): array {
            return [
                'discussion_count' => Discussion::count(),
                'user_count' => User::count(),
                'comment_post_count' => CommentPost::count(),
                'tags_count' => Tag::count(),
                'blog_count' => BlogMeta::count(),
                'group_count' => Group::count(),
                'online_guests' => $this->getGuestCount(),
                'online_users' => $this->getOnlineUsers(), //User::isOnline(),
            ];
        }) ?: [];

        if (empty($stats)) {
            return ['litalino-flarum-forum-stats-widget.stats' => null];
        }

        return [
            'litalino-flarum-forum-stats-widget.stats' => [
                'discussionCount' => [
                    'label' => $this->translator->trans('flarum-forum-stats-widget.forum.widget.stats.discussion_count'),
                    'icon' => 'far fa-comments',
                    'value' => $stats['discussion_count'],
                    'prettyValue' => pretty_number_format($stats['discussion_count']),
                ],
                'userCount' => [
                    'label' => $this->translator->trans('flarum-forum-stats-widget.forum.widget.stats.user_count'),
                    'icon' => 'fas fa-users',
                    'value' => $stats['user_count'],
                    'prettyValue' => pretty_number_format($stats['user_count']),
                ],
                'commentPostCount' => [
                    'label' => $this->translator->trans('flarum-forum-stats-widget.forum.widget.stats.comment_post_count'),
                    'icon' => 'far fa-comment-dots',
                    'value' => $stats['comment_post_count'],
                    'prettyValue' => pretty_number_format($stats['comment_post_count']),
                ],
                'TagsCount' => [
                    'label' => $this->translator->trans('flarum-forum-stats-widget.forum.widget.stats.tags_count'),
                    'icon' => 'fas fa-tag',
                    'value' => $stats['tags_count'],
                    'prettyValue' => pretty_number_format($stats['tags_count']),
                ],
                'BlogCount' => [
                    'label' => $this->translator->trans('flarum-forum-stats-widget.forum.widget.stats.blog_count'),
                    'icon' => 'fas fa-blog',
                    'value' => $stats['blog_count'],
                    'prettyValue' => pretty_number_format($stats['blog_count']),
                ],
                'GroupCount' => [
                    'label' => $this->translator->trans('flarum-forum-stats-widget.forum.widget.stats.group_count'),
                    'icon' => 'fas fa-users',
                    'value' => $stats['group_count'],
                    'prettyValue' => pretty_number_format($stats['group_count']),
                ],
                'onlineGuests' => [
                    'label' => $this->translator->trans('flarum-forum-stats-widget.forum.widget.stats.online_guests'),
                    'icon' => 'fas fa-circle blue',
                    'value' => $stats['online_guests'],
                    'prettyValue' => pretty_number_format($stats['online_guests']),
                ],
                'onlineUsers' => [
                    'label' => $this->translator->trans('flarum-forum-stats-widget.forum.widget.stats.online_users'),
                    'icon' => 'fas fa-circle green',
                    'value' => $stats['online_users'],
                    'prettyValue' => pretty_number_format($stats['online_users']),
                ],
            ],
        ];
    }

    //Online guests
    protected function getGuestCount(): int
    {
        if ($this->sessionHandler instanceof FileSessionHandler) {
            return $this->fromFiles();
        }

        // TODO: add Redis, Database, etc support.

        return 0;
    }

    private function fromFiles(): int
    {
        $reflection = new \ReflectionClass($this->sessionHandler);
        $pathProperty = $reflection->getProperty('path');
        $pathProperty->setAccessible(true);
        $sessionFilesPath = $pathProperty->getValue($this->sessionHandler);

        $recentlyActiveSessionFiles = Finder::create()
            ->in($sessionFilesPath)
            ->files()
            ->ignoreDotFiles(true)
            ->date('>= now - '.$this->onlineDurationMinutes.' minutes');

        $sessions = [];
        foreach ($recentlyActiveSessionFiles as $file) {
            $sessions[] = unserialize(file_get_contents($file->getRealPath()));
        }

        $guestSessions = array_filter($sessions, function ($session) {
            return ! isset($session['access_token']);
        });

        return count($guestSessions);
    }

    //Nnline user
    public function getLastSeenUsers(): array
    {
        $time = Carbon::now()->subMinutes($this->onlineDurationMinutes);
        $limit = 50;

        //$canViewLastSeen = $actor->hasPermission('user.viewLastSeenAt');
        //$suffix = $canViewLastSeen ? '-permitted' : '-restricted';
        
        //return $this->cache->remember('ekumanov-online-users-widget.users'.$suffix, 40, function () use ($actor, $time, $limit, $canViewLastSeen) {
            return User::query()
                ->select('id', 'preferences')
                //->whereVisibleTo($actor)
                ->where('last_seen_at', '>', $time)
                ->limit($limit + 1)
                ->get()
                //->filter(function ($user) use ($canViewLastSeen) {
                //    return $canViewLastSeen or $user->getPreference('discloseOnline');
                //})
                ->pluck('id')
                ->toArray();
        //}) ?: [];
    }

    //New user
    public function getOnlineUsers(): int
    {
        return count(User::whereIn('id', $this->getLastSeenUsers())->get());
    }

    public function getLatestUser(): ?User
    {
        return User::query()->orderBy('joined_at', 'DESC')->limit(1)->first();
    }

    public function getLatestUserId(): ?int
    {
        return $this->getLatestUser() ? $this->getLatestUser()->id : null;
    }
}
