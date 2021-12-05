<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Providers;

use Model;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider as BaseUserProvider;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;

/**
 * Class UserProvider
 * @package ReaZzon\JWTAuth\Classes\Providers
 */
class UserProvider implements BaseUserProvider
{
    /**
     * The Eloquent user model.
     *
     * @var Model string
     */
    protected $model;

    /**
     * имя параметра в credentials, который содержит код авторизации
     */
    protected const CODE = 'code';

    /**
     * Create a new database user provider.
     *
     * @param string $model
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return Authenticatable|null
     */
    public function retrieveById($identifier): ?Authenticatable
    {
        $model = $this->createModel();
        $user = $model->newQuery()
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();

        if ($user) {
            /** @var UserPluginResolver $userPluginResolver */
            $userPluginResolver = app(UserPluginResolver::class);
            $userPluginResolver
                ->getProvider()
                ->login($user);
        }

        return $user;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param mixed $identifier
     * @param string $token
     * @return Authenticatable|null
     */
    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        return null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param Authenticatable $user
     * @param string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token): void
    {
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (empty($credentials) ||
            (count($credentials) === 1 &&
                array_key_exists(static::CODE, $credentials))) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value) {
            if (!Str::contains($key, self::CODE)) {
                $query->where($key, $value);
            }
        }

        $user = $query->first();
        if ($user) {
            $user = $user->getJWTSubject();
        }

        return $user;
    }


    /**
     * Create a new instance of the model.
     *
     * @return Authenticatable
     */
    public function createModel(): Authenticatable
    {
        $class = '\\' . ltrim($this->model, '\\');

        return new $class;
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @return false
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return false;
    }
}
