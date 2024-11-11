<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Doctype
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $template
 * @property string|null $questions
 * @property int $user_id
 * @property int $single_sign
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Doctype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereQuestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereSingleSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Doctype whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Doctype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Doctype withoutTrashed()
 */
	class Doctype extends \Eloquent {}
}

namespace App\models{
/**
 * App\models\Acl
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $parent_id
 * @property int $user_id
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Brand[] $brands
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Module[] $module
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\models\Acl onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Acl whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Acl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Acl whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Acl whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Acl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Acl whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Acl whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Acl whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Acl whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Acl withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\models\Acl withoutTrashed()
 */
	class Acl extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Device
 *
 * @property int $id
 * @property string $description
 * @property string $serial
 * @property int $user_id
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\models\Acl[] $acls
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device withoutTrashed()
 */
	class Device extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Document
 *
 * @property int $id
 * @property string $date_doc
 * @property string $name
 * @property string|null $identifier
 * @property string|null $description
 * @property string $filename
 * @property int|null $doctype_id
 * @property int $dossier_id
 * @property int $signed
 * @property int $readonly
 * @property string|null $date_sign
 * @property int $user_id
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctype|null $doctype
 * @property-read \App\Models\Dossier $dossier
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Document onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereDateDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereDateSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereDoctypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereDossierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereReadonly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereSigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Document withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Document withoutTrashed()
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MailTemplate
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $brand_id
 * @property int $user_id
 * @property int $active
 * @property string|null $template
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Brand $brand
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailTemplate whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailTemplate whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailTemplate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailTemplate whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailTemplate whereUserId($value)
 */
	class MailTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdditionalDataDossiers
 *
 * @property int $id
 * @property int $dossier_id
 * @property string|null $veicolo_targa
 * @property string|null $veicolo_marca
 * @property string|null $veicolo_modello
 * @property string|null $veicolo_allestimento
 * @property string|null $veicolo_cavalli_fiscali
 * @property string|null $veicolo_valore_assicurato
 * @property string|null $veicolo_stato_vaicolo
 * @property string|null $veicolo_data_immatricolazione
 * @property string|null $veicolo_numero_telaio
 * @property string|null $contratto_polizza
 * @property string|null $contratto_societa
 * @property string|null $contratto_durata
 * @property string|null $contratto_importo
 * @property string|null $contratto_data_scadenza_vincolo
 * @property string|null $contratto_data_decorrenza
 * @property string|null $contratto_data_scadenza
 * @property string|null $venditore
 * @property string|null $incentivo
 * @property string|null $note
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdditionalDataDossiers onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereContrattoDataDecorrenza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereContrattoDataScadenza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereContrattoDataScadenzaVincolo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereContrattoDurata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereContrattoImporto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereContrattoPolizza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereContrattoSocieta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereDossierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereIncentivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVeicoloAllestimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVeicoloCavalliFiscali($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVeicoloDataImmatricolazione($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVeicoloMarca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVeicoloModello($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVeicoloNumeroTelaio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVeicoloStatoVaicolo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVeicoloTarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVeicoloValoreAssicurato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdditionalDataDossiers whereVenditore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdditionalDataDossiers withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdditionalDataDossiers withoutTrashed()
 */
	class AdditionalDataDossiers extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Log
 *
 * @property int $id
 * @property string $env
 * @property string $message
 * @property string $level
 * @property array $context
 * @property array $extra
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereEnv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereUpdatedAt($value)
 */
	class Log extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $name
 * @property string|null $surname
 * @property string $email
 * @property string|null $vat
 * @property string|null $personal_vat
 * @property string|null $address
 * @property string|null $city
 * @property string|null $region
 * @property string|null $zip_code
 * @property string|null $contact
 * @property string|null $phone
 * @property string|null $mobile
 * @property int $user_id
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\models\Acl[] $acls
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dossier[] $documents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dossier[] $dossiers
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client wherePersonalVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereZipCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client withoutTrashed()
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $description
 * @property string|null $sector
 * @property string $address
 * @property string $city
 * @property string|null $zip_code
 * @property string $region
 * @property string|null $contact
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $fax
 * @property string $email
 * @property int $user_id
 * @property int $brand_id
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\models\Acl[] $acls
 * @property-read \App\Models\Brand $brand
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereZipCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location withoutTrashed()
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Profile
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\models\Acl[] $acls
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Module[] $modules
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Profile onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Profile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Profile withoutTrashed()
 */
	class Profile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Module
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $functions
 * @property string|null $icon
 * @property int $isadmin
 * @property int $active
 * @property int $user_id
 * @property int|null $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereFunctions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereIsadmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module withoutTrashed()
 */
	class Module extends \Eloquent {}
}

namespace App\models{
/**
 * App\models\Visibility
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $parent_id
 * @property int $user_id
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Brand[] $brands
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\models\Visibility onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Visibility whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Visibility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Visibility whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Visibility whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Visibility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Visibility whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Visibility whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Visibility whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\Visibility whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\Visibility withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\models\Visibility withoutTrashed()
 */
	class Visibility extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string|null $name
 * @property string|null $surname
 * @property string $email
 * @property string $password
 * @property int $active
 * @property int $user_id
 * @property int|null $profile_id
 * @property int|null $acl_id
 * @property string|null $session_id
 * @property string $api_token
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\models\Acl[] $acls
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Module[] $modules
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Models\Profile|null $profile
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAclId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Dossier
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $date_dossier
 * @property int $client_id
 * @property string|null $note
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\AdditionalDataDossiers $additionalDossier
 * @property-read \App\Models\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dossier onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereDateDossier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dossier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dossier withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Dossier withoutTrashed()
 */
	class Dossier extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $description
 * @property string $vat
 * @property string|null $personal_vat
 * @property string|null $sector
 * @property string $address
 * @property string $city
 * @property string|null $zip_code
 * @property string $region
 * @property string|null $contact
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $fax
 * @property string $email
 * @property string|null $smtp_host
 * @property int|null $smtp_port
 * @property string|null $smtp_username
 * @property string|null $smtp_password
 * @property int $user_id
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\models\Acl[] $acls
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read \App\Models\MailTemplate $mail_templates
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Brand onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand wherePersonalVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereSmtpHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereSmtpPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereSmtpPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereSmtpUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereZipCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Brand withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Brand withoutTrashed()
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TokenOtp
 *
 * @property int $id
 * @property string $token
 * @property int $user_id
 * @property int $client_id
 * @property string $phone
 * @property int $document_id
 * @property int $signed
 * @property string|null $otp
 * @property string|null $expired_time
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereExpiredTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereSigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TokenOtp whereUserId($value)
 */
	class TokenOtp extends \Eloquent {}
}

