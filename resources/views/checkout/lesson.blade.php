<x-layout title="Comprar acesso - {{ $lesson->title }}">
    <div class="max-w-2xl mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Comprar acesso à aula</h1>
            <p class="text-gray-500 text-sm mb-6">{{ $lesson->title }}</p>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4 mb-6">
                <span class="text-gray-600">Valor</span>
                <span class="text-2xl font-bold text-green-600">R$ {{ number_format($lesson->price, 2, ',', '.') }}</span>
            </div>

            <form action="{{ route('checkout.lesson.process', $lesson) }}" method="POST">
                @csrf

                <p class="text-sm font-medium text-gray-700 mb-3">Forma de pagamento</p>
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <label class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition">
                        <input type="radio" name="billing_type" value="PIX" class="sr-only" required>
                        <span class="text-lg font-bold text-green-600">PIX</span>
                        <span class="text-xs text-gray-500 mt-1">Aprovação imediata</span>
                    </label>
                    <label class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition">
                        <input type="radio" name="billing_type" value="CREDIT_CARD" class="sr-only">
                        <span class="text-lg font-bold text-blue-600">Cartão</span>
                        <span class="text-xs text-gray-500 mt-1">Crédito</span>
                    </label>
                    <label class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition">
                        <input type="radio" name="billing_type" value="BOLETO" class="sr-only">
                        <span class="text-lg font-bold text-gray-600">Boleto</span>
                        <span class="text-xs text-gray-500 mt-1">1-3 dias úteis</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                    Gerar pagamento
                </button>
            </form>

            <a href="{{ route('courses.lesson', [$lesson->course_id, $lesson->id]) }}" class="block text-center text-sm text-gray-400 hover:text-gray-600 mt-4">
                Voltar à aula
            </a>
        </div>
    </div>
</x-layout>
