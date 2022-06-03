<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use Faker\Factory;
use yii\helpers\Url;
use app\models\{User, Album};

/**
 * This command fills DB by data.
 */
class SeedController extends Controller
{
    /**
     * Create User, Album and Photos.
     * 
     * @return int Exit code
     */
    public function actionIndex()
    {
        $faker = Factory::create();
        $users = $albums = $photos = [];
        $db = Yii::$app->db;
        $security = Yii::$app->security;
          
        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                $faker->userName(),
                $faker->firstName(),
                $faker->lastName(),
                $security->generateRandomString(),
                $security->generatePasswordHash($faker->password()),
                $faker->unixTime(),
                $faker->unixTime()
            ];
        }
        $db->createCommand()->batchInsert('user', ['username', 'first_name', 'last_name', 'auth_key',
            'password_hash', 'created_at', 'updated_at'], $users)->execute();
            
        foreach (User::find()->select('id')->orderBy('id DESC')->limit(10)->column() as $user) {
            for ($i = 0; $i < 10; $i++) {
                $albums[] = [$user, $faker->word()];
            }
        }
        $db->createCommand()->batchInsert('album', ['user_id', 'title'], $albums)->execute();
        
        foreach (Album::find()->select('id')->orderBy('id DESC')->limit(100)->column() as $album) {
            for ($i = 1; $i < 11; $i++) {
                $photos[] = [$album, $faker->word(), '/images/' . $i . '.png'];
            }
        }
        $db->createCommand()->batchInsert('photo', ['album_id', 'title', 'url'], $photos)->execute();
            
        unset($posts, $albums, $photos);
        
        return $this->stdout('Done');
    }
}