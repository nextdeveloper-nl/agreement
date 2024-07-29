<?php

namespace NextDeveloper\Agreement\Services;

use Illuminate\Support\Facades\DB;
use NextDeveloper\Agreement\Services\AbstractServices\AbstractContractsService;
use NextDeveloper\Commons\Exceptions\NotAllowedException;
use NextDeveloper\IAM\Services\UsersService;


/**
 * This class is responsible from managing the data for Contracts
 *
 * Class ContractsService.
 *
 * @package NextDeveloper\Agreement\Database\Models
 */
class ContractsService extends AbstractContractsService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    /**
     * @throws NotAllowedException
     * @throws \Exception
     */
    public static function create(array $data)
    {

        $signerService = new SignatureService();

        $templateId = $data['template_reference'] ?? config('agreement.defaults.template_id');

        $createDocument = $signerService->createDocument($data['name'], $templateId);
        $data['reference'] = $createDocument;

        $create = parent::create($data);


        $user = UsersService::getById($create->iam_user_id);

        if (!$user) {
            throw new \Exception('User not found');
        }

        $sendDocument = $signerService->fillDocumentWithData(
            $createDocument,
            [
                'name'      => $user->fullname,
                'email'     => $user->email,
                'phone'     => $user->phone_number,
                'channel'   => config('agreement.defaults.channel')
            ]
        );

        parent::update($create->uuid, ['data' => $sendDocument]);

        return $create;

    }

}
