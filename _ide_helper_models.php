<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models{
    /**
     * @property int $id
     * @property string $nama
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     *
     * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel query()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel whereNama($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminLevel whereUpdatedAt($value)
     *
     * @mixin \Eloquent
     *
     * @property-read \App\Models\TFactory|null $use_factory
     *
     * @method static \Database\Factories\AdminLevelFactory factory($count = null, $state = [])
     */
    class AdminLevel extends \Eloquent {}
}

namespace App\Models{
    /**
     * @property int $id
     * @property string $nama_pelanggan
     * @property string $username
     * @property string $password
     * @property string $alamat
     * @property int $nomor_kwh
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int $tarif_kwh_id
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PembayaranKWH> $PembayaranKWH
     * @property-read int|null $pembayaran_k_w_h_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenggunaanKWH> $PenggunaanKWH
     * @property-read int|null $penggunaan_k_w_h_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TagihanKWH> $TagihanKWH
     * @property-read int|null $tagihan_k_w_h_count
     * @property-read \App\Models\TFactory|null $use_factory
     *
     * @method static \Database\Factories\PelangganFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan query()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereAlamat($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNamaPelanggan($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNomorKwh($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereTarifKwhId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereUsername($value)
     *
     * @mixin \Eloquent
     */
    class Pelanggan extends \Eloquent {}
}

namespace App\Models{
    /**
     * @property int $id
     * @property int $tagihan_kwh_id
     * @property int $pelanggan_id
     * @property float $total_tagihan
     * @property float $biaya_admin
     * @property float|null $total_bayar
     * @property \Illuminate\Support\Carbon|null $tanggal_pembayaran
     * @property int $user_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\TFactory|null $use_factory
     * @property-read \App\Models\Pelanggan|null $pelangganKWH
     * @property-read \App\Models\TagihanKWH|null $tagihanKWH
     * @property-read \App\Models\User|null $userAdmin
     *
     * @method static \Database\Factories\PembayaranKWHFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH query()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereBiayaAdmin($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH wherePelangganId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereTagihanKwhId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereTanggalPembayaran($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereTotalBayar($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereTotalTagihan($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PembayaranKWH whereUserId($value)
     *
     * @mixin \Eloquent
     */
    class PembayaranKWH extends \Eloquent {}
}

namespace App\Models{
    /**
     * @property int $id
     * @property int|null $pelanggan_id
     * @property string $bulan
     * @property int $tahun
     * @property int $meter_awal
     * @property int $meter_akhir
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\TFactory|null $use_factory
     *
     * @method static \Database\Factories\PenggunaanKWHFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH query()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereBulan($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereMeterAkhir($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereMeterAwal($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH wherePelangganId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereTahun($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|PenggunaanKWH whereUpdatedAt($value)
     *
     * @mixin \Eloquent
     */
    class PenggunaanKWH extends \Eloquent {}
}

namespace App\Models{
    /**
     * @property int $id
     * @property int|null $pelanggan_id
     * @property int|null $penggunaan_kwh_id
     * @property string $bulan
     * @property string $tahun
     * @property int $jumlah_meter
     * @property bool $status
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\Pelanggan|null $PelangganKWH
     * @property-read \App\Models\PembayaranKWH|null $PembayaranKWH
     * @property-read \App\Models\PenggunaanKWH|null $PenggunaanKWH
     * @property-read \App\Models\TFactory|null $use_factory
     *
     * @method static \Database\Factories\TagihanKWHFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH query()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereBulan($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereJumlahMeter($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH wherePelangganId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH wherePenggunaanKwhId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereTahun($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TagihanKWH whereUpdatedAt($value)
     *
     * @mixin \Eloquent
     */
    class TagihanKWH extends \Eloquent {}
}

namespace App\Models{
    /**
     * @property int $id
     * @property int $daya
     * @property string $tarif_perkwh
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     *
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH query()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereDaya($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereTarifPerkwh($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|TarifKWH whereUpdatedAt($value)
     *
     * @mixin \Eloquent
     *
     * @property-read \App\Models\TFactory|null $use_factory
     *
     * @method static \Database\Factories\TarifKWHFactory factory($count = null, $state = [])
     */
    class TarifKWH extends \Eloquent {}
}

namespace App\Models{
    /**
     * @property int $id
     * @property string $name
     * @property string $username
     * @property string $password
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int|null $admin_level_id
     * @property-read \App\Models\AdminLevel|null $adminLevel
     * @property-read \App\Models\TFactory|null $use_factory
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PembayaranKWH> $pembayaranKWH
     * @property-read int|null $pembayaran_k_w_h_count
     *
     * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAdminLevelId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
     *
     * @mixin \Eloquent
     */
    class User extends \Eloquent {}
}
