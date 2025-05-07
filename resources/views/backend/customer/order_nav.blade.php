<div class="d-flex gap-1 align-items-center justify-content-end">
    <a href="{{ route('customer_view',$user->id) }}" class="btn btn-sm header-icon"><i class="bx bx-shopping-bag"></i> Order</a>
    <a href="{{ route('customer_e_puja',$user->id) }}" class="btn btn-sm header-icon"><i class='bx bx-add-to-queue'></i> E-Puja Order</a>
    <a href="#" class="btn btn-sm header-icon"><i class='bx bx-bell'></i> Notifications</a>
</div>
