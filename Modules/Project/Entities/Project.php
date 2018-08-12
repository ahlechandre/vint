<?php

namespace Modules\Project\Entities;

use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Modules\Group\Entities\Servant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Group\Entities\Collaborator;
use Modules\Group\Entities\Student;

class Project extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'program_id',
        'coordinator_user_id',
        'leader_user_id',
        'supporter_user_id',
        'name',
        'description',
        'start_on',
        'finish_on'
    ];

    /**
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value, '-');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coordinator()
    {
        return $this->belongsTo(Servant::class, 'coordinator_user_id', 'member_user_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(Servant::class, 'leader_user_id', 'member_user_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supporter()
    {
        return $this->belongsTo(Collaborator::class, 'supporter_user_id', 'member_user_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'project_student',
            'project_id',
            'student_user_id',
            'member_user_id'
        );
    }
}
