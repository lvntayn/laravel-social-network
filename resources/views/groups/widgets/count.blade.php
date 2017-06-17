<div class="count_widget">
    <div class="row">
        <div class="col-xs-6">
            <a class="green" href="{{ url('/group/'.$group->id.'/stats') }}">
                {{ $group->countPeople($city->id) }}
            </a>
            {{ $city->name }}
        </div>
        <div class="col-xs-6">
            <a class="blue" href="{{ url('/group/'.$group->id.'/stats') }}">
                {{ $group->countPeople() }}
            </a>
            Total
        </div>
    </div>
</div>

