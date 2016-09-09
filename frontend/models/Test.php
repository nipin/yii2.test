<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $date_standard
 * @property string $date_new
 */
class Test extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['text'], 'string'],
            [['date_standard', 'date_new'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
            'date_standard' => 'Date Standard',
            'date_new' => 'Date New',
        ];
    }
}
