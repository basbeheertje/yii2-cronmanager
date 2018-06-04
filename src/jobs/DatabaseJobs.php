<?php

namespace basbeheertje\yii2\cronmanager\jobs;

use Yii;
use yii\base\BaseObject;

/**
 * This task could be enabled on the test api server to remove imported data and insert new random sample data
 */
class DatabaseJobs extends BaseObject
{
    public function optimizeTables(){
        /** @var \yii\db\Connection $db */
        $db = Yii::$app->getDb();
        /** @var string $dbname */
        $dbname = self::getDsnAttribute('dbname', $db->dsn);

        $getAllTablesCommand = Yii::$app->getDb()->createCommand('SHOW TABLES');
        /** @var array $tables */
        $tables = $getAllTablesCommand->queryAll();
        foreach ($tables as $table) {
            $tablename = $table["Tables_in_" . $dbname];
            $optimizeTableCommand = $db->createCommand("OPTIMIZE TABLE " . $tablename);
            try {
                $optimizeTableCommand->query();
            } catch (Exception $e) {
                $message = "ERROR optimize table " . $tablename . " , " . $dbname . " Timestamp=" . date("d-m-Y H:i:s");
                Yii::$app->MailComponent->sendError($message);
            }
        }
        return true;
    }

    /**
     * @todo describe
     * @param string $name
     * @param $dsn
     * @return null
     */
    private static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
}