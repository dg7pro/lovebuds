<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class UsersTableMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $users = $this->table('users',['id' => false, 'primary_key' => ['id'], 'collation'=>'utf8mb4_unicode_ci']);
        $users->addColumn('id','integer',['signed'=>false,'identity'=>true])

            // account details - 15
            ->addColumn('pid', 'string', ['limit' => 20,'null'=>false])
            ->addColumn('email', 'string', ['limit' => 255,'null'=>false])
            ->addColumn('mobile', 'string', ['limit' => 10,'null'=>false])
            ->addColumn('whatsapp', 'string', ['limit' => 10,'null'=>true])
            ->addColumn('password_hash', 'string', ['limit' => 255,'null'=>false])
            ->addColumn('ev','boolean')
            ->addColumn('mv','boolean')
            ->addColumn('ac','integer', ['null'=>false,'default'=>0])
            ->addColumn('is_active','boolean')
            ->addColumn('is_block','boolean')
            ->addColumn('is_admin','boolean')
            ->addColumn('is_paid','boolean')
            ->addColumn('is_verified','boolean')
            ->addColumn('for_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>false])
            ->addForeignKey('for_id', 'fors', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addColumn('gender','integer',['limit'=>1,'signed' => false,'null'=>false])

            // profile details - 10
            ->addColumn('first_name', 'string', ['limit' => 30,'null'=>true])
            ->addColumn('last_name', 'string', ['limit' => 30,'null'=>true])
            ->addColumn('avatar','string',['limit'=>255,'null'=>false])
            ->addColumn('dob','date',['null'=>false])
            ->addColumn('height_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('tongue_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('marital_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('religion_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('community_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('caste_id','smallinteger',['signed' => false,'null'=>true])

            ->addForeignKey('height_id', 'heights', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('tongue_id', 'tongues', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('marital_id', 'maritals', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('religion_id', 'religions', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('community_id', 'communities', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('caste_id', 'castes', 'value', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])


            // partner preference -4
            ->addColumn('min_age','integer',['limit'=>MysqlAdapter::INT_TINY,  'signed'=>false, 'null'=>false, 'default'=>18])
            ->addColumn('max_age','integer',['limit'=>MysqlAdapter::INT_TINY,  'signed'=>false, 'null'=>false, 'default'=>72])
            ->addColumn('min_ht','integer',['limit'=>MysqlAdapter::INT_TINY,  'signed'=>false, 'null'=>false, 'default'=>1])
            ->addColumn('max_ht','integer',['limit'=>MysqlAdapter::INT_TINY,  'signed'=>false, 'null'=>false, 'default'=>30])

            // education & occupation - 8
            ->addColumn('education_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('occupation_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('degree_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('university_id','smallinteger',['signed'=>false, 'null'=>true])
            ->addColumn('sector_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false, 'null'=>true])
            ->addColumn('income_id', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false, 'null'=>true])
            ->addColumn('other_deg', 'string', ['limit' => 255,'null'=>true])
            ->addColumn('working_in', 'string', ['limit' => 255,'null'=>true])

            ->addForeignKey('education_id', 'educations', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('occupation_id', 'occupations', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('degree_id', 'degrees', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('university_id', 'universities', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('sector_id', 'sectors', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('income_id', 'incomes', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])

            // family details - 12
            ->addColumn('father_name', 'string', ['limit' => 100,'null'=>true])
            ->addColumn('mother_name', 'string', ['limit' => 100,'null'=>true])
            ->addColumn('father_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('mother_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('bros','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false, 'null'=>true])
            ->addColumn('mbros','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false, 'null'=>true])
            ->addColumn('sis','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false, 'null'=>true])
            ->addColumn('msis','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('famAffluence_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('famValue_id','integer', ['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('famType_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('famIncome_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])

            ->addForeignKey('father_id', 'fathers', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('mother_id', 'mothers', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('famAffluence_id', 'fam_affluence', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('famValue_id', 'fam_values', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('famType_id', 'fam_types', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('famIncome_id', 'fam_incomes', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])


            // lifestyle details - 13
            ->addColumn('diet_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('smoke_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('drink_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('pets','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('house','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('car','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('body_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('complexion_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('weight_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('bGroup_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('hiv','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('thalassemia_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('challenged_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])

            ->addForeignKey('diet_id', 'diets', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('smoke_id', 'smokes', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('drink_id', 'drinks', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('body_id', 'bodies', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('complexion_id', 'complexions', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('bGroup_id', 'blood_groups', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('thalassemia_id', 'thalassemia', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('challenged_id', 'challenged', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])


            // location details & settings - 5
            ->addColumn('country_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('state','string',['limit'=>255,'null'=>true])
            ->addColumn('district','string',['limit'=>255,'null'=>true])
            ->addColumn('citizenship_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('rsa','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])

            ->addForeignKey('country_id', 'countries', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('citizenship_id', 'citizenship', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])

            // astro details & settings - 8
            ->addColumn('sun_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('moon_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('manglik_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('nakshatra_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>true])
            ->addColumn('horoscope','boolean',['null'=>false,'default'=>1])
            ->addColumn('kundli_details', 'string', ['limit' => 255,'null'=>true])
            ->addColumn('hm','integer',['limit'=>MysqlAdapter::INT_TINY])
            ->addColumn('hp','integer',['limit'=>MysqlAdapter::INT_TINY])

            ->addForeignKey('sun_id', 'signs', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('moon_id', 'rashis', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('manglik_id', 'mangliks', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('nakshatra_id', 'nakshatras', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])

            // multi select fields - 4
            ->addColumn('myhobbies','text',['limit' => MysqlAdapter::TEXT_LONG])
            ->addColumn('myinterests','text',['limit' => MysqlAdapter::TEXT_LONG])
            ->addColumn('mycastes','text',['limit' => MysqlAdapter::TEXT_LONG])
            ->addColumn('langs','text',['limit' => MysqlAdapter::TEXT_LONG])

            // boolean - 5
            ->addColumn('photo','boolean')      // have photo or not
            ->addColumn('cnb','boolean')        // caste no bar
            ->addColumn('pm','boolean')         // preferably manglik
            ->addColumn('fb_add','boolean')     // facebook add
            ->addColumn('one_way','boolean')    // one way communication

            // activation & password reset - 5
            ->addColumn('activation_hash','string',['limit'=>64, 'null'=>true])
            ->addColumn('password_reset_hash','string',['limit'=>64, 'null'=>true])
            ->addColumn('password_reset_expire_at', 'datetime',['null'=>true])
            ->addColumn('created_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])

            ->addIndex(['pid', 'email'], ['unique' => true])
            ->create();

    }
}
