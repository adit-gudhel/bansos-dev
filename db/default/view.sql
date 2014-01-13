DROP VIEW IF EXISTS v_dncpbh_opd;
CREATE VIEW v_dncpbh_opd AS 
SELECT a.opd_nama as opd,
	b.jh_jenis as jenis, 
	c.hib_nama as nama,
	c.hib_kode, 
	CONCAT(`hib_jalan`,' RT.',`hib_rt`,' / RW.',`hib_rw`) as alamat, d.nm_kelurahan as kelurahan,e.nm_kecamatan as kecamatan,
	f.nm_dati2 as kota,
	g.nm_propinsi as propinsi,
	c.hib_kodepos as kodepos, 
	c.hib_ren_guna as rencana_penggunaan,
	c.hib_besaran_hibah as permohonan,
	h.besaran_opd as hasil_evaluasi_opd,
	h.keterangan,
	h.status as status_opd,
	h.kode,
	i.tipe,
	i.ba_no as no_ba,
	i.ba_tgl as tgl_ba
FROM tbl_opd a, tbl_jenis_hibah b, tbl_hibah c, tbl_kelurahan d, tbl_kecamatan e, tbl_dati2 f, tbl_propinsi g, tbl_berita_acara_detail h, tbl_berita_acara i
WHERE c.opd_kode=a.opd_kode AND c.jh_kode=b.jh_kode AND c.kd_kelurahan=d.kd_kelurahan AND c.kd_kecamatan=e.kd_kecamatan AND c.kd_dati2=f.kd_dati2 AND c.kd_propinsi=g.kd_propinsi AND c.hib_kode=h.hib_kode AND h.kode=i.kode AND i.tipe='HIBAH';

DROP VIEW IF EXISTS v_dncpbh_tapd;
CREATE VIEW v_dncpbh_tapd AS
SELECT a.opd_nama as opd,
	b.jh_jenis as jenis, 
	c.hib_nama as nama,
	c.hib_kode, 
	CONCAT(`hib_jalan`,' RT.',`hib_rt`,' / RW.',`hib_rw`) as alamat, d.nm_kelurahan as kelurahan,e.nm_kecamatan as kecamatan,
	f.nm_dati2 as kota,
	g.nm_propinsi as propinsi,
	c.hib_kodepos as kodepos, 
	c.hib_ren_guna as rencana_penggunaan,
	c.hib_besaran_hibah as permohonan,
	h.besaran_opd as hasil_evaluasi_opd,
	j.besaran_tapd as hasil_evaluasi_tapd,
	j.keterangan,
	h.status as status_opd,
	j.status as status_tapd,
	j.kode,
	k.tipe,
	k.ba_no as no_ba,
	k.ba_tgl as tgl_ba
FROM tbl_opd a, tbl_jenis_hibah b, tbl_hibah c, tbl_kelurahan d, tbl_kecamatan e, tbl_dati2 f, tbl_propinsi g, tbl_berita_acara_detail h, tbl_berita_acara i, tbl_eval_tapd_detail j, tbl_eval_tapd k
WHERE c.opd_kode=a.opd_kode AND c.jh_kode=b.jh_kode AND c.kd_kelurahan=d.kd_kelurahan AND c.kd_kecamatan=e.kd_kecamatan AND c.kd_dati2=f.kd_dati2 AND c.kd_propinsi=g.kd_propinsi AND c.hib_kode=h.hib_kode AND h.kode=i.kode AND i.tipe='HIBAH' AND c.hib_kode=j.hib_kode AND j.kode=k.kode AND k.tipe ='HIBAH';

DROP VIEW IF EXISTS v_dncpbs_opd;
CREATE VIEW v_dncpbs_opd AS
SELECT  a.opd_nama as opd,
	b.jh_jenis as jenis, 
	c.ban_nama as nama,
	c.ban_ktp as ktp,
	c.ban_kode, 
	CONCAT(`ban_jalan`,' RT.',`ban_rt`,' / RW.',`ban_rw`) as alamat, d.nm_kelurahan as kelurahan,e.nm_kecamatan as kecamatan,
	f.nm_dati2 as kota,
	g.nm_propinsi as propinsi,
	c.ban_kodepos as kodepos, 
	c.ban_ren_guna as rencana_penggunaan,
	c.ban_besaran_bansos as permohonan,
	h.besaran_opd as hasil_evaluasi_opd,
	h.keterangan,
	h.status as status_opd,
	h.kode,
	i.tipe,
	i.ba_no as no_ba,
	i.ba_tgl as tgl_ba
FROM tbl_opd a, tbl_jenis_hibah b, tbl_bansos c, tbl_kelurahan d, tbl_kecamatan e, tbl_dati2 f, tbl_propinsi g, tbl_berita_acara_detail h, tbl_berita_acara i
WHERE c.opd_kode=a.opd_kode AND c.jh_kode=b.jh_kode AND c.kd_kelurahan=d.kd_kelurahan AND c.kd_kecamatan=e.kd_kecamatan AND c.kd_dati2=f.kd_dati2 AND c.kd_propinsi=g.kd_propinsi AND h.hib_kode=c.ban_kode AND h.kode=i.kode AND i.tipe='BANSOS';

DROP VIEW IF EXISTS v_dncpbs_tapd;
CREATE VIEW v_dncpbs_tapd AS
SELECT a.opd_nama as opd,
	b.jh_jenis as jenis, 
	c.ban_nama as nama,
	c.ban_ktp as ktp,
	c.ban_kode, 
	CONCAT(`ban_jalan`,' RT.',`ban_rt`,' / RW.',`ban_rw`) as alamat, d.nm_kelurahan as kelurahan,e.nm_kecamatan as kecamatan,
	f.nm_dati2 as kota,
	g.nm_propinsi as propinsi,
	c.ban_kodepos as kodepos, 
	c.ban_ren_guna rencana_penggunaan,
	c.ban_besaran_bansos as permohonan,
	h.besaran_opd as hasil_evaluasi_opd,
	j.besaran_tapd as hasil_evaluasi_tapd,
	j.keterangan,
	h.status as status_opd,
	j.status as status_tapd,
	j.kode,
	k.tipe,
	k.ba_no as no_ba,
	k.ba_tgl as tgl_ba
FROM tbl_opd a, tbl_jenis_hibah b, tbl_bansos c, tbl_kelurahan d, tbl_kecamatan e, tbl_dati2 f, tbl_propinsi g, tbl_berita_acara_detail h, tbl_berita_acara i, tbl_eval_tapd_detail j, tbl_eval_tapd k
WHERE c.opd_kode=a.opd_kode AND c.jh_kode=b.jh_kode AND c.kd_kelurahan=d.kd_kelurahan AND c.kd_kecamatan=e.kd_kecamatan AND c.kd_dati2=f.kd_dati2 AND c.kd_propinsi=g.kd_propinsi AND c.ban_kode=h.hib_kode AND h.kode=i.kode AND i.tipe='BANSOS' AND c.ban_kode=j.hib_kode AND j.kode=k.kode AND k.tipe ='BANSOS';