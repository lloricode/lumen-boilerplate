<?php

declare(strict_types=1);

namespace App\Models\Auth\User\Traits;

use App\Models\Auth\User\SocialAccount;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

trait UserRegularFunction
{
    public function fullNameShorten(): string
    {
        return strlen($this->fullName()) > 40
            ? substr($this->fullName(), 0, 40).' ...'
            : $this->fullName();
    }

    public function fullName(): string
    {
        return $this->last_name
            ? $this->first_name.' '.$this->last_name
            : $this->first_name;
    }

    public function hasProvider(string $provider, string $providerId = null): bool
    {
        //        foreach ($this->socialAccounts as $socialAccount) {
        //            if (
        //                $socialAccount->provider == $provider &&
        //                $socialAccount->provider_id == $providerId
        //            ) {
        //                return true;
        //            }
        //        }
        //
        return SocialAccount::where(
            $providerId
                ? [
                    'user_id' => $this->id,
                    'provider' => $provider,
                    'provider_id' => $providerId,
                ]
                : [
                    'user_id' => $this->id,
                    'provider' => $provider,
                ]
        )->get()->count() > 0;
    }

    public function getSocialAccountButtons()
    {
        $accounts = [];

        foreach ($this->socialAccounts as $social) {
            // TODO: route unlink social logic
            $accounts[] = html()
                ->a('#', '<i class="fa fa-'.$social->provider.'"></i>')
                ->attributes(
                    [
                        'title' => 'unlink',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'data-method' => 'delete',
                    ]
                );
        }

        return blank($accounts) ? 'n/a' : implode(' ', $accounts);
    }

    /**
     * @param  string  $conversionName
     *
     * @return string|null
     * @throws \Creativeorange\Gravatar\Exceptions\InvalidEmailException
     */
    public function getAvatar(string $conversionName = ''): ?string
    {
        switch ($this->avatar_type) {
            case 'gravatar':
                return app('gravatar')->get($this->email);
            case 'storage':
                return url($this->getFirstMediaUrl('profile', $conversionName));
        }

        $socialAvatar = $this->socialAccounts()->where('provider', $this->avatar_type)->first();

        if ($socialAvatar && strlen($socialAvatar->avatar)) {
            return $socialAvatar->avatar;
        }

        return null;
    }

    /**
     * @param  string  $avatarTypeFormInput
     * @param  \Illuminate\Http\UploadedFile|null  $uploadedFile
     */
    public function updateAvatar(string $avatarTypeFormInput, UploadedFile $uploadedFile = null)
    {
        switch ($avatarTypeFormInput) {
            case 'storage':
                $this->addMedia($uploadedFile)->toMediaCollection('profile');
                $this->update(
                    [
                        'avatar_type' => 'storage',
                    ]
                );
                break;

            case 'social':
                /** @var \App\Models\Auth\SocialAccount $social */
                $social = $this->socialAccounts->first();
                if ( ! blank($social)) {
                    $this->update(
                        [
                            'avatar_type' => $social->provider,
                        ]
                    );
                    $this->clearMediaCollection('profile');
                }
                break;

            case 'gravatar':
                $this->update(
                    [
                        'avatar_type' => 'gravatar',
                    ]
                );
                $this->clearMediaCollection('profile');
                break;

            default:
                throw new InvalidArgumentException("Invalid argument [$avatarTypeFormInput]");
                break;
        }
    }
}
