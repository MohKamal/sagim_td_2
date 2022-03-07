@foreach(Auth::user()->commands() as $command)
<div class="border-card">
    <div class="card-type-icon with-border">1</div>
        <div class="content-wrapper">
            <div class="label-group fixed">
                <p class="title">Date</p>
                @php
                    $date=date_create($command->created_at);
                    $created = date_format($date,"d/m/Y H:i:s");
                @endphp
                <p class="caption">{{$created}}</p>
            </div>
            <div class="min-gap"></div>
            <div class="label-group">
                <p class="title">Total Price</p>
                <p class="caption">${{$command->total()}}</p>
            </div>
            <div class="min-gap"></div>
            <div class="label-group">
                <p class="title">Payed</p>
                @php
                    $payed = 'No';
                    if($command->payment() !== null) {
                        $payed = $command->payment()->payed == true ? 'Yes' : 'No';
                    }
                @endphp
                <p class="caption">{{$payed}}</p>
            </div>
        </div>
    </div>
</div>
@endforeach