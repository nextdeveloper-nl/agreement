<?php

namespace NextDeveloper\Agreement\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Authorization\Roles\AbstractRole;
use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Database\Models\Users;


class AgreementAdminRole extends AbstractRole implements IAuthorizationRole
{

    public const NAME = 'agreement-admin';

    public const LEVEL = 100;

    public const DESCRIPTION = 'Agreement Admin';

    public const DB_PREFIX = 'agreement';

    public function apply(Builder $builder, Model $model)
    {
        //  Returns everything about agreement
    }

    public function checkPrivileges(Users $users = null)
    {
        //return UserHelper::hasRole(self::NAME, $users);
    }

    public function getModule(): string
    {
        return 'agreement';
    }

    public function allowedOperations() :array
    {
        return [
            'agreement_contracts:read',
            'agreement_contracts:create',
            'agreement_contracts:update',
            'agreement_contracts:delete',
            'agreement_templates:read',
            'agreement_templates:create',
            'agreement_templates:update',
            'agreement_templates:delete',
            'agreement_webhooks:read',
            'agreement_webhooks:create',
            'agreement_webhooks:update',
            'agreement_webhooks:delete',
        ];
    }

    public function getLevel(): int
    {
        return self::LEVEL;
    }

    public function getDescription(): string
    {
        return self::DESCRIPTION;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function canBeApplied($column): bool
    {
        if(self::DB_PREFIX === '*') {
            return true;
        }

        if(Str::startsWith($column, self::DB_PREFIX)) {
            return true;
        }

        return false;
    }

    public function getDbPrefix(): string
    {
        return self::DB_PREFIX;
    }

    public function checkRules(Users $users)
    {
        // TODO: Implement checkRules() method.
    }

}
