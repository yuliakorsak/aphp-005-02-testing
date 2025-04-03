<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UserTableWrapper::class)]
class TableWrapperTest  extends TestCase
{
    public const START_ARRAY = [
        [
            'username' => 'ivan',
            'password' => 'dem0',
        ],
        [
            'username' => 'qwerty',
            'password' => 'password',
        ],
        [
            'username' => 'kitkat',
            'password' => 'random123',
        ]
    ];

    public static function startTable(): UserTableWrapper
    {
        $users = new UserTableWrapper();
        foreach (self::START_ARRAY as $row) {
            $users->insert($row);
        }
        return $users;
    }

    #[CoversMethod(UserTableWrapper::class, "get")]
    public function testGet(): void
    {
        $users = new UserTableWrapper();
        $this->assertIsArray($users->get());
    }

    #[CoversMethod(UserTableWrapper::class, "insert")]
    public function testInsert(): void
    {
        $users = self::startTable();
        $this->assertEquals(self::START_ARRAY, $users->get());
    }

    public static function providerUpdate(): array
    {
        return [
            [
                ['password' => 'NewPassword'],
                ['username' => 'qwerty', 'password' => 'NewPassword']
            ],
            [
                ['username' => 'ivan1999', 'password' => 'demo0demo'],
                ['username' => 'ivan1999', 'password' => 'demo0demo']
            ]
        ];
    }

    #[CoversMethod(UserTableWrapper::class, "update")]
    #[DataProvider('providerUpdate')]
    public function testUpdate($updateValue, $expected): void
    {
        $users = self::startTable();
        $id = 1;
        $result = $users->update($id, $updateValue);
        $this->assertEquals($result, $expected);
    }

    #[CoversMethod(UserTableWrapper::class, "delete")]
    public function testDelete(): void
    {
        $expected = [
            0 => [
                'username' => 'ivan',
                'password' => 'dem0'
            ],
            2 => [
                'username' => 'kitkat',
                'password' => 'random123'
            ]
        ];
        $users = self::startTable();
        $users->delete(1);
        $this->assertEquals($users->get(), $expected);
    }
}
