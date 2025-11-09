<?php

namespace Database\Seeders;

use App\Constants\DBTypes;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    protected $types = [
        [
            'code' => DBTypes::UserRole,
            'name' => 'User Role',
            'children' => [
                [
                    'name' => 'Super Admin',
                    'desc' => 'important',
                    'code' => DBTypes::RoleSuperAdmin
                ],
                [
                    'name' => 'Admin',
                    'code' => DBTypes::RoleAdmin
                ]
            ]
        ],
        [
            'code' => DBTypes::UserGender,
            'name' => 'User Gender',
            'children' => [
                [
                    'name' => 'Laki - Laki',
                    'desc' => 'important',
                    'code' => DBTypes::UserGenderM
                ],
                [
                    'name' => 'Perempuan',
                    'desc' => 'important',
                    'code' => DBTypes::UserGenderF
                ]
            ]
        ],
        [
            'code' => DBTypes::FileTypes,
            'name' => 'File Type',
            'children' => [
                [
                    'name' => 'Type Picture',
                    'desc' => 'important',
                    'code' => DBTypes::FileTypePic
                ],
                [
                    'name' => 'Profile Picture',
                    'desc' => 'important',
                    'code' => DBTypes::FileProfilePic
                ],
                [
                    'name' => 'Post Thumbnail',
                    'desc' => 'important',
                    'code' => DBTypes::FilePostThumbnail
                ],
                [
                    'name' => 'Kover Berita',
                    'desc' => 'important',
                    'code' => DBTypes::FileKoverBerita
                ]
            ]
        ],
        [
            'code' => DBTypes::PostCategories,
            'name' => 'Post Categories',
            'children' => [
                [
                    'name' => 'Gossip',
                    'desc' => 'important',
                    'code' => DBTypes::PostCategoriesGossip
                ],
                [
                    'name' => 'Action',
                    'code' => DBTypes::PostCategoriesAction
                ]
            ]
        ],
        [
            'code' => DBTypes::KategoriBerita,
            'name' => 'Kategori Berita',
            'children' => [
                [
                    'name' => 'Pendidkan',
                    'desc' => 'important',
                    'code' => DBTypes::KategoriBeritaPendidkan
                ],
                [
                    'name' => 'Teknologi',
                    'code' => DBTypes::KategoriBeritaTeknologi
                ]
            ]
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(Type $type): void
    {
        foreach ($this->types as $key => $value) {
            $parent = $type->create(collect($value)->only($type->getFillable())->toArray());
            if (isset($value['children']))
                $this->createChildren($type, $parent->id, $value['children']);
        }
    }

    public function createChildren(Type $type, int $masterid, array $children)
    {
        foreach ($children as $key => $value) {
            $value['master_id'] = $masterid;
            $child = $type->create(collect($value)->only($type->getFillable())->toArray());
            if (isset($value['children']))
                $this->createChildren($type, $child->id, $value['children']);
        }
    }
}
