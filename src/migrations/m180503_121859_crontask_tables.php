<?php

use yii\db\Migration;

/**
 * Class m180503_121859_crontask_tables
 */
class m180503_121859_crontask_tables extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        if (!in_array('tasks', $this->getDb()->schema->tableNames)) {
            $this->execute(
                "CREATE TABLE `tasks` (
    `task_id` SMALLINT(6) NOT NULL AUTO_INCREMENT,
        `time` VARCHAR(64) NOT NULL,
        `command` VARCHAR(256) NOT NULL,
        `status` ENUM('active', 'inactive', 'deleted') DEFAULT 'active',
        `comment` VARCHAR(256) DEFAULT NULL,
        `ts` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `ts_updated` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY(`task_id`)
        ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8"
            );
        }

        if (!in_array('task_runs', $this->getDb()->schema->tableNames)) {

            $this->execute(
                "CREATE TABLE `task_runs` (
            `task_run_id` INT(11) NOT NULL AUTO_INCREMENT,
        `task_id` SMALLINT(6) NOT NULL,
        `status` ENUM('started', 'completed', 'error') DEFAULT NULL,
        `execution_time` DECIMAL(6, 2) NOT NULL DEFAULT '0.00',
        `ts` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `output` TEXT,
        PRIMARY KEY(`task_run_id`),
        KEY `task_id` (`task_id`), KEY `ts` (`ts`)
        ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;");

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task_runs');
        $this->dropTable('tasks');
    }
}
