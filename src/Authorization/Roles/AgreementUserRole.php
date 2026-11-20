<?php

namespace NextDeveloper\Agreement\Authorization\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\IAM\Helpers\UserHelper;
use Illuminate\Support\Str;
use NextDeveloper\IAM\Authorization\Roles\AbstractRole;
use NextDeveloper\IAM\Authorization\Roles\IAuthorizationRole;
use NextDeveloper\IAM\Database\Models\Users;


class AgreementUserRole extends AbstractRole implements IAuthorizationRole
{
    public const NAME = 'agreement-user';

    public const LEVEL = 150;

    public const DESCRIPTION = 'Agreement User';

    public const DB_PREFIX = 'agreement';

    public function apply(Builder $builder, Model $model)
    {
        //  This role used to return every agreement row of every account. It now sees its own account's rows only.
        $accountId = UserHelper::currentAccount()->id;
        $table = $model->getTable();

        //  Templates are shared: the account's own templates plus the ones without an owner (platform templates).
        if ($table == 'agreement_templates') {
            $builder->where(function (Builder $q) use ($accountId) {
                $q->where('agreement_templates.iam_account_id', $accountId)
                    ->orWhereNull('agreement_templates.iam_account_id');
            });

            return;
        }

        //  Inbound webhook payloads (no owner column) are not customer data: fail closed.
        if ($table == 'agreement_webhooks') {
            $builder->whereRaw('1 = 0');

            return;
        }

        if (\NextDeveloper\Commons\Helpers\DatabaseHelper::isColumnExists($table, 'iam_account_id')) {
            $builder->where($table . '.iam_account_id', $accountId);

            return;
        }

        //  Unknown table without an owner column: fail closed.
        $builder->whereRaw('1 = 0');
    }

    public function checkPrivileges(?Users $users = null)
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
