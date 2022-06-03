<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "album".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 *
 * @property Photo[] $photos
 * @property User $user
 */
class Album extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'album';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Photos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['album_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * Get user first name.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFirstName()
    {
        return $this->user->first_name;
    }
    
    /**
     * Get user last name.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLastName()
    {
        return $this->user->last_name;
    }
    
    /**
     * @inheritdoc
     */
    public function fields()
    { 
        return array_merge(['id', 'title'], Yii::$app->controller->id == 'albums' &&
            Yii::$app->controller->action->id == 'view' ? ['firstName', 'lastName', 'photos'] : []);
    }
}