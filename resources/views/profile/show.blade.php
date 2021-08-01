<x-app-layout>
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-capitalize">
                            <a href="{{route('dashboard')}}">
                                <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Update Profile</span>
                            </a>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>