<?php


    namespace Modules\Flight\Models;


    use App\BaseModel;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\Flight\Factories\AirLineFactory;
    use Modules\Media\Models\MediaFile;

    class Airline extends BaseModel
    {
        use HasFactory;
        use SoftDeletes;

        protected $table ='bravo_airline';
        protected $fillable = ['name','image_id'];

        protected static function newFactory()
        {
            return AirLineFactory::new();
        }

        public function logo(){
            return $this->belongsTo(MediaFile::class,'image_id','id')->withDefault();
        }
    }