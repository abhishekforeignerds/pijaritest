<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-centered border table-nowrap mb-lg-0 table">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Delivery Status</th>
                                <th class="text-center">Delivery Boy</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sub_dates as $date)
                                <tr>
                                    <td class="text-center">{{$date->date}}</td>
                                    <td class="text-center">{{$date->quantity}}</td>
                                    <td class="text-center">
                                        <select class="form-select" aria-label="Status"  id="status_{{$date->id}}" >
                                            <option value="">Select Status</option>
                                            <option value="confirmed" @if($date->status =='confirmed') selected @endif >Confirmed </option>
                                            <option value="shipped"  @if($date->status =='shipped') selected @endif >  Shipped </option>
                                            <option value="delivered" @if($date->status =='delivered') selected @endif >Delivered</option>
                                            <option value="cancelled" @if($date->status =='cancelled') selected @endif>Cancelled </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" name="delivery_boy_id" id="delivery_boy_id_{{$date->id}}">
                                            <option value="">Select Delivery Person</option>
                                            @foreach ($delivery_boy as $person)
                                             <option value="{{$person->id}}" @if($date->delivery_boy_id == $person->id) selected @endif >{{$person->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="col-4">
                                            @if($date->status != 'cancelled')
                                            <button class="btn btn-primary" @if(!empty($date->delivery_boy_id)) style="background:green;"   @endif id="button_{{$date->id}}" onclick="update_status('{{$date->id}}')">Update</button>
                                            @else
                                             <p style="color:red;">Cancelled</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
