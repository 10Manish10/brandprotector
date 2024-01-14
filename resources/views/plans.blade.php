@extends('layouts.admin')
@section('content')

<style>
    .wraps1 {
        padding: 20px;
        margin-bottom: 50px;
    }
    .wraps2 {
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.17);
        background: rgba(0, 0, 0, 0.76);
        backdrop-filter: blur(92.5px);
        padding: 50px 35px;
        width: calc(100% - 15px);
        margin: 0 auto;
        height: calc(100% + 50px);
    }
    .cbcb {
        list-style: none;
        margin-left: 0;
        padding-left: 0;
    }
    .cbcb li {
        padding-left: 1.8em;
        font-size: 18px;
        margin-bottom: 18px;
        position: relative;
    }
    .cbcb li:before {
        content: "";
        background-image: url(https://cdn.shopify.com/s/files/1/0284/1254/3021/files/check.svg?v=1697785455);
        background-size: 22px 22px;
        width: 22px;
        height: 22px;
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }
    .wraps3 {
        position: relative;
        height: 100%;
    }
    .sub_btn {
        border-radius: 4px;
        background: #6BC1E7;
        color: #000;
        text-align: center;
        font-size: 18px;
        font-weight: 900;
        width: 100%;
        padding: 8px 0;
        position: absolute;
        top: auto;
        bottom: 30px;
        left: 0;
        right: 0;
        transform: translateY(100%);
    }
    .wraps2 .headrr {
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .headrr .titll {
        font-size: 25px;
        font-weight: 900;
    }
    .headrr .pric {
        font-size: 18px;
        font-weight: 700;
        border-radius: 4px;
        background: rgba(217, 217, 217, 0.06);
        padding: 10px 20px;
    }
</style>

<div class="card">
    <div class="card-body">
        <div class="container-fluid">
            @if ($metaData['error'] != "")
                <p class="danger">{{$metaData['error']}}</p>
            @endif
            @if ($metaData['paymentStatus'] == "success")
                <p style="color:green;">Your payment is Successful. You can now avail the plan benefits.</p>
            @elseif ($metaData['paymentStatus'] == "cancelled")
                <p style="color:red;">Your payment got cancelled, please try again.</p>
            @endif
            <br><br>
            <h1 class="text-center">Our Plans</h1>
            <br>
            <h4 class="text-center">Choose the plan which will protect your brand the best!</h4>
            <br><br>
            <div class="row justify-center">
                @foreach ($data as $row)
                    <div class="col-4 wraps1">
                        <div class="wraps2">
                            <div class="wraps3">
                                <form method="POST" action="{{ route("plans.createPayment") }}">
                                    @csrf
                                    <div class="headrr">
                                        <p class="titll">{{ $row->name }}</p>
                                        <?php $money = round($row->plan_amount, 0); ?>
                                        @if ($money > 0)
                                            <p class="pric">${{ $money }} /Mo</p>
                                            <input type="hidden" name="plan_id" value="{{ $row->id }}">
                                            <input type="hidden" name="amount" value="{{ $money }}">
                                            <input type="hidden" name="txn_desc" value="{{ $row->name }}">
                                        @else
                                            <p class="pric">INQUIRE WITHIN</p>
                                        @endif
                                    </div>
                                    <?php $feats = explode(",", $row->features); ?>
                                    <ul class="cbcb">
                                        @foreach ($feats as $f)
                                            <li>{{ $f }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="submit" class="button sub_btn">Proceed with this Plan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <br><br>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
</script>
@endsection
