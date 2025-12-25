<x-modal :title="'Lengkapi Pemesanan'" :showClose="false">
    @section("content")
        <form 
            wire:submit.prevent="saveUserInfo"
            x-data="{
                name: @entangle('name'),
                phone: @entangle('phone'),
                errors: { name: '', phone: '' },
                validateName() {
                    if (!this.name || this.name.length < 2) {
                        this.errors.name = 'Nama minimal 2 karakter';
                        return false;
                    }
                    if (!/^[a-zA-Z\s]+$/.test(this.name)) {
                        this.errors.name = 'Nama hanya boleh huruf dan spasi';
                        return false;
                    }
                    this.errors.name = '';
                    return true;
                },
                validatePhone() {
                    const phoneRegex = /^(\+62|62|0)8[1-9][0-9]{6,10}$/;
                    if (!this.phone) {
                        this.errors.phone = 'Nomor HP wajib diisi';
                        return false;
                    }
                    if (!phoneRegex.test(this.phone.replace(/[\s-]/g, ''))) {
                        this.errors.phone = 'Format nomor HP tidak valid (contoh: 08123456789)';
                        return false;
                    }
                    this.errors.phone = '';
                    return true;
                },
                validate() {
                    return this.validateName() && this.validatePhone();
                }
            }"
        >
            <div class="mb-6 mt-4 space-y-4">
                <div class="flex flex-col space-y-1">
                    <label
                        class="text-xs font-semibold text-black-50"
                        for="name"
                    >
                        Nama Pemesan
                    </label>
                    <input
                        :class="errors.name ? 'border-red-500' : 'border-black-30'"
                        class="rounded-lg border px-2 py-1.5"
                        type="text"
                        name="name"
                        x-model="name"
                        @blur="validateName()"
                        wire:model.live="name"
                    />
                    <span x-show="errors.name" x-text="errors.name" class="text-xs text-red-500"></span>
                    @error("name")
                        <span class="text-xs text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="flex flex-col space-y-1">
                    <label
                        class="text-xs font-semibold text-black-50"
                        for="phone"
                    >
                        Nomor Handphone
                    </label>
                    <input
                        :class="errors.phone ? 'border-red-500' : 'border-black-30'"
                        class="rounded-lg border px-2 py-1.5"
                        type="tel"
                        name="phone"
                        x-model="phone"
                        @blur="validatePhone()"
                        wire:model.live="phone"
                        placeholder="08xxxxxxxxxx"
                    />
                    <span x-show="errors.phone" x-text="errors.phone" class="text-xs text-red-500"></span>
                    @error("phone")
                        <span class="text-xs text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button
                    x-on:click="open = false"
                    type="button"
                    class="cursor-pointer rounded-full bg-primary-10 px-5 py-2 font-semibold text-primary-60 outline-none hover:bg-primary-20"
                >
                    Kembali
                </button>
                <button
                    @click="if(!validate()) $event.preventDefault()"
                    x-on:click="if(validate()) open = false"
                    type="submit"
                    class="cursor-pointer rounded-full bg-primary-50 px-5 py-2 font-semibold text-white hover:bg-primary-60"
                >
                    <span class="flex items-center gap-1.5">
                        Terapkan
                        <img
                            src="{{ asset("assets/icons/arrow-right-white-icon.svg") }}"
                            alt="Terapkan"
                        />
                    </span>
                </button>
            </div>
        </form>
    @endsection
</x-modal>
