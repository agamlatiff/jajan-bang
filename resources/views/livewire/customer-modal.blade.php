<x-modal :title="'Lengkapi Pemesanan'" :showClose="false" :allowClose="false">
    @section("content")
        <form 
            wire:submit.prevent="saveUserInfo"
            x-data="{
                name: @entangle('name'),
                phone: @entangle('phone'),
                errors: { name: '', phone: '' },
                get isValid() {
                    return this.name && this.name.length >= 2 && this.phone && /^(\+62|62|0)8[1-9][0-9]{6,10}$/.test(this.phone.replace(/[\s-]/g, ''));
                },
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
            class="pb-4"
        >
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                <span class="text-red-500">*</span> Wajib diisi sebelum memesan
            </p>
            
            <div class="mb-8 space-y-5">
                <div class="space-y-2">
                    <label
                        class="text-sm font-semibold text-gray-700 dark:text-gray-300"
                        for="name"
                    >
                        Nama Pemesan <span class="text-red-500">*</span>
                    </label>
                    <input
                        :class="errors.name ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-800 dark:text-white'"
                        class="w-full rounded-xl border p-3 text-sm shadow-sm transition-all focus:ring-1 focus:outline-none placeholder:text-gray-400"
                        type="text"
                        name="name"
                        required
                        minlength="2"
                        x-model="name"
                        @blur="validateName()"
                        @input="validateName()"
                        wire:model.live="name"
                        placeholder="Contoh: Budi Santoso"
                    />
                    <span x-show="errors.name" x-text="errors.name" class="text-xs text-red-500"></span>
                    @error("name")
                        <span class="text-xs text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label
                        class="text-sm font-semibold text-gray-700 dark:text-gray-300"
                        for="phone"
                    >
                        Nomor Handphone <span class="text-red-500">*</span>
                    </label>
                    <input
                        :class="errors.phone ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-800 dark:text-white'"
                        class="w-full rounded-xl border p-3 text-sm shadow-sm transition-all focus:ring-1 focus:outline-none placeholder:text-gray-400"
                        type="tel"
                        name="phone"
                        required
                        x-model="phone"
                        @blur="validatePhone()"
                        @input="validatePhone()"
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

            <div class="flex items-center justify-between gap-4">
                <button
                    x-on:click="if(isValid) open = false"
                    :disabled="!isValid"
                    type="button"
                    :class="isValid ? 'bg-primary-50 text-primary-600 hover:bg-primary-100 cursor-pointer' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                    class="flex-1 rounded-full px-5 py-3 font-semibold transition-colors"
                >
                    Kembali
                </button>
                <button
                    @click="if(!validate()) $event.preventDefault()"
                    x-on:click="if(validate()) open = false"
                    :disabled="!isValid"
                    type="submit"
                    :class="isValid ? 'bg-primary-600 hover:bg-primary-700 cursor-pointer shadow-lg shadow-primary-600/20' : 'bg-gray-300 cursor-not-allowed'"
                    class="flex-2 rounded-full px-5 py-3 font-semibold text-white transition-colors"
                >
                    <div class="flex items-center justify-center gap-2">
                        <span>Terapkan</span>
                        <span class="material-icons text-sm">arrow_forward</span>
                    </div>
                </button>
            </div>
        </form>
    @endsection
</x-modal>

