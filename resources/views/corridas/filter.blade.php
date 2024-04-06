<x-dialog-modal wire:model.live="open" id="modalFilter">
    <x-slot name="title">
        {{__('Filter')}}
    </x-slot>
    <x-slot name="content">

        <!-- Teste Field -->
        <div class="sm:text-start text-center">
          <div class="grid sm:grid-cols-2 grid-cols-1">
            <div class="sm:pr-4">
                {!! Form::label('dateTypeFilter', __('Date type').':',['class' => "block mx-1"]) !!}
                {!! Form::select('dateTypeFilter', ['C' => __('Created'),'U' => __('Updated'),'D' => __('Deleted') ],$dateType, ['class' => 'input w-full px-2','required' => 'true','wire:model.live' => 'dateType','id' => 'dateTypeFilter']) !!} 
            </div>
          </div>
          <!-- Teste Field -->
          <div class="grid sm:grid-cols-2 grid-cols-1">
            <div class="sm:pr-4">
                {!! Form::label('initialDate', __('Initial Date').':',['class' => "block mx-1"]) !!}
                {!! Form::datetimelocal('initialDate', $initialDate, ['class' => 'input w-full px-2','required' => 'true','wire:model.live' => 'initialDate','id' => 'initialDateFilter']) !!}
            </div>
            <div>
              {!! Form::label('endDate', __('End Date').':',['class' => "block mx-1"]) !!}
              {!! Form::datetimelocal('endDate',$endDate, ['class' => 'input w-full px-2','required' => 'true','wire:model.live' => 'endDate','id' => 'endDateFilter']) !!} 
            </div>
          </div>
        </div>

    </x-slot>

    <x-slot name="footer">
        <x-button class="btn-secondary ml-3" type="submit" wire:click="resetFields">
            {{__('Reset Fields')}}
            <x-loader wire:loading wire:target="resetFields"/>
          </div>
        </x-button>
    </x-slot>
</x-dialog-modal>

