<?php

namespace Shadowlab\Configuration;

use Aura\Di\Container;
use Aura\Di\Config;

class Actions extends Config
{
    public function define(Container $di)
    {
        $di->params['Shadowlab\Dispatcher\Dispatcher'] = [
            'container' => $di,
            'response'  => $di->lazyNew('Shadowlab\Responses\Blank'),
            'session'   => $di->lazyNew('Shadowlab\Session\Session'),
            'router'    => $di->lazyNew('Shadowlab\Router\Router')
        ];

        $di->params['Shadowlab\Interfaces\Action\AbstractAction'] = [
            'http'    => $di->lazyNew('Shadowlab\Responses\Blank'),
            'session' => $di->lazyNew('Shadowlab\Session\Session'),
            'request' => $di->lazyNew('Aura\Web\Request')
        ];

        /*
         * USER ACTIONS
         */

        $di->params['Shadowlab\Actions\User\LoginAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Login')
        ];

        $di->params['Shadowlab\Actions\User\LogoutAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Logout')
        ];

        $di->params['Shadowlab\Actions\User\AuthenticateAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Login')
        ];

        $di->params['Shadowlab\Actions\User\AutoAuthenticateAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Login')
        ];

        $di->params['Shadowlab\Actions\User\Accounts\ResetAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Accounts\Reset')
        ];

        $di->params['Shadowlab\Actions\User\Accounts\LookUpAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Accounts\LookUp')
        ];

        $di->params['Shadowlab\Actions\User\Accounts\ReconfirmAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Accounts\Reconfirm')
        ];

        $di->params['Shadowlab\Actions\User\Accounts\UnlockAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\User\User'),
            'http'   => $di->lazyNew('Shadowlab\Responses\User\Accounts\Unlock')
        ];



        $di->params['Shadowlab\Actions\Cheatsheets\IndexAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Index')
        ];

        /*
         * COMBAT SHEETS
         */

        $di->params['Shadowlab\Actions\Cheatsheets\IndexCombatAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexCombat')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Combat\CalledShotsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Combat\CalledShots\CalledShots'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Combat\CalledShots')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Combat\CalledShotsAmmoAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Combat\CalledShotsAmmo\CalledShotsAmmo'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Combat\CalledShotsAmmo')
        ];
        
        $di->params['Shadowlab\Actions\Cheatsheets\Combat\CalledShotsLocationsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Combat\CalledShotsLocations\CalledShotsLocations'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Combat\CalledShotsLocations')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Combat\CombatActionsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Combat\CombatActions\CombatActions'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Combat\CombatActions')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Combat\MartialArtsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Combat\MartialArts\MartialArts'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Combat\MartialArts')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Combat\MartialArtsTechniquesAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Combat\MartialArtsTechniques\MartialArtsTechniques'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Combat\MartialArtsTechniques')
        ];

        /*
         * GEAR SHEETS
         */

        $di->params['Shadowlab\Actions\Cheatsheets\Gear\Entry\Vehicles'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Gear\Vehicles\Vehicles'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Gear\Entry\Vehicles')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Gear\Vehicles'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Gear\Vehicles\Vehicles'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Gear\Vehicles')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Gear\Entry\Weapons'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Gear\Weapons\Weapons'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Gear\Entry\Weapons')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Gear\Weapons'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Gear\Weapons\Weapons'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Gear\Weapons')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Gear\Entry\WeaponAccessories'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Gear\WeaponAccessories\WeaponAccessories'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Gear\Entry\WeaponAccessories')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Gear\WeaponAccessories'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Gear\WeaponAccessories\WeaponAccessories'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Gear\WeaponAccessories')
        ];

        /*
         * MAGIC SHEETS
         */

        $di->params['Shadowlab\Actions\Cheatsheets\IndexMagicAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexMagic')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\AdeptPowersAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptPowers\AdeptPowers'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\AdeptPowers')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\AdeptWaysAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\AdeptWays\AdeptWays'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\AdeptWays')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\Enchantments'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Enchantments\Enchantments'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Enchantments')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\MentorSpiritsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits\MentorSpirits'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\MentorSpirits')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\MetamagicsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Metamagics\Metamagics'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Metamagics')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\Entry\Rituals'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Rituals\Rituals'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Entry\Rituals')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\Rituals'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Rituals\Rituals'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Rituals')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\Schools'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Schools\Schools'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Schools')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\SpellsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spells\Spells'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Spells')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\SpiritPowersAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\SpiritPowers\SpiritPowers'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\SpiritPowers')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\SpiritsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Spirits\Spirits'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Spirits')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Magic\TraditionsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Magic\Traditions\Traditions'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Magic\Traditions')
        ];

        /*
         * MATRIX SHEETS
         */

        $di->params['Shadowlab\Actions\Cheatsheets\IndexMatrixAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexMatrix')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\ComplexFormsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms\ComplexForms'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\ComplexForms')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\IntrusionCountermeasuresAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures\IntrusionCountermeasures'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\IntrusionCountermeasures')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\MatrixActionsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\MatrixActions\MatrixActions'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\MatrixActions')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\ProgramsAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\Programs\Programs'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\Programs')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\SpriteDatabaseAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase\SpriteDatabase'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\SpriteDatabase')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Matrix\SpritePowersAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers\SpritePowers'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Matrix\SpritePowers')
        ];

        /*
         * OTHER SHEETS
         */

        $di->params['Shadowlab\Actions\Cheatsheets\IndexOtherAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Cheatsheets'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\IndexOther')
        ];

        $di->params['Shadowlab\Actions\Cheatsheets\Other\QualitiesAction'] = [
            'domain' => $di->lazyNew('Shadowlab\Domains\Cheatsheets\Other\Qualities\Qualities'),
            'http'   => $di->lazyNew('Shadowlab\Responses\Cheatsheets\Other\Qualities')
        ];
    }
}
