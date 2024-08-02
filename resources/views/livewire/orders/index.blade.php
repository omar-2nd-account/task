<div class='bg-white p-20'>
    <div class='min-h-[80vh] rounded-2xl rounded-b-none shadow border border-zinc-100'>
      <div class='flex flex-col'>
        <div class="w-full bg-neutral-100 rounded-t-2xl">
          <div class='flex flex-col gap-4 px-8 pt-8 pb-6'>
            <div class='flex flex-row'>
                <input type='text' wire:model.live.debounce.100ms="searchInputText" placeholder='Search client name, phone' class='w-full p-2 ps-10 border-2 bg-transparent border-neutral-200 rounded-l-md focus:outline-none' />
            </div>
            <div class='grid grid-cols-6'>
              <div class="text-start text-zinc-600 text-sm font-semibold uppercase">Order ID</div>
              <div class="text-start text-zinc-600 text-sm font-semibold uppercase">Client Name</div>
              <div class="text-start text-zinc-600 text-sm font-semibold uppercase">Phone Number</div>
              <div class="text-start text-zinc-600 text-sm font-semibold uppercase">Product Code</div>
              <div class="text-start text-zinc-600 text-sm font-semibold uppercase">Final Price</div>
              <div class="text-start text-zinc-600 text-sm font-semibold uppercase">Quantity</div>
            </div>
          </div>
        </div>
        <div class='w-full grid grid-cols gap-8 py-6'>

           @foreach ($orders as $order)
                <div class="grid grid-cols-6 gap-4 px-8"
                    x-data='{ 
                        order: @json($order),
                        open: false,
                        toggle() { 
                            this.open = !this.open
                            console.log(this.order)
                        },
                    }',
                >
                    <div class="fixed inset-0 flex justify-center items-center" x-show="open">
                        <div class="relative min-w-[85%] rounded-2xl shadow border border-zinc-100 bg-white p-10 items-center justify-center">
                            <button
                                class="absolute top-0 right-0 m-4 text-zinc-600 hover:text-zinc-800"
                                @click="toggle"
                            >
                                <img src="{{ asset('icons/close.svg') }}" width="24" height="24" alt="" />
                            </button>
                            <div class='flex flex-col gap-5items-center'>
                                <div class="text-neutral-400 text-sm font-medium uppercase">Product Information</div>
                                <div class='flex flex-col gap-3 pt-4 pl-5'>
                                    <div class='flex flex-row gap-3'>
                                        <div class="text-neutral-400 text-sm font-normal font-['Inter']">Product ID</div>
                                        <div class="text-black text-sm font-normal font-['Inter']" x-text="order.product.id"></div>
                                    </div>
                                    <div class='flex flex-row gap-3'>
                                        <div class="text-neutral-400 text-sm font-normal font-['Inter']">Product Name</div>
                                        <div class="text-black
                                        text-sm font-normal font-['Inter']" x-text="order.product.name"></div>
                                    </div>
                                    <div class='flex flex-row gap-3'>
                                        <div class="text-neutral-400 text-sm font-normal font-['Inter']">Product Description</div>
                                        <div class="text-black
                                        text-sm font-normal font-['Inter']" x-text="order.product.description"></div>
                                    </div>
                                    <div class='flex flex-row gap-3'>
                                        <div class="text-neutral-400 text-sm font-normal font-['Inter']">Quantity</div>
                                        <div class="text-black
                                        text-sm font-normal font-['Inter']" x-text="order.quantity"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-zinc-900 text-sm font-normal font-['Inter']">{{ $order->id }}</div>
                    <div class="text-zinc-900 text-sm font-normal font-['Inter']">{{ $order->client_name }}</div>
                    <div class="text-zinc-900 text-sm font-normal font-['Inter']">{{ $order->phone_number }}</div>
                    <div class="text-zinc-900 text-sm font-normal font-['Inter'] underline hover:cursor-pointer" @click="toggle">{{ $order->productCode->product_code }}</div>
                    <div class="text-zinc-900 text-sm font-normal font-['Inter']">{{ $order->final_price }}</div>
                    <div class="text-zinc-900 text-sm font-normal font-['Inter']">{{ $order->quantity }}</div>
                </div>
            @endforeach
        </div>
      </div>
    </div>
    <div class='w-full bg-neutral-100 rounded-b-2xl shadow border border-zinc-100'>
      <div class='flex justify-center items-center p-4'>
        <div class="flex flex-row gap-4 justify-between mx-auto">
            {{ $orders->links() }}
        </div>
      </div>
    </div>
  </div>