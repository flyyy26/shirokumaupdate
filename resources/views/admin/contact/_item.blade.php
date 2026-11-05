<div class="contact-item group bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm p-4 hover:border-blue-500/50 transition-all duration-300 cursor-pointer {{ !$contact->is_read ? 'border-blue-500/30' : '' }}"
     onclick="openDetail({{ $contact->id }})"
     data-id="{{ $contact->id }}">
    
    <div class="flex items-start justify-between gap-4">
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <input type="checkbox" class="contact-checkbox rounded border-gray-600 text-blue-600 focus:ring-blue-500" 
                   value="{{ $contact->id }}" onclick="event.stopPropagation(); updateSelected();">
            
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center">
                    <span class="text-blue-400 font-semibold text-sm">{{ substr($contact->name, 0, 1) }}</span>
                </div>
            </div>
            
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <h4 class="text-white font-medium text-sm {{ !$contact->is_read ? 'font-bold' : '' }}">
                        {{ $contact->name }}
                    </h4>
                    <span class="text-xs text-gray-500">{{ $contact->email }}</span>
                </div>
                <p class="text-gray-400 text-sm truncate">{{ $contact->message }}</p>
            </div>
        </div>
        
        <div class="flex items-center gap-2 flex-shrink-0">
            <span class="px-2 py-0.5 rounded-full text-xs font-medium 
                {{ $contact->is_replied ? 'bg-green-500/20 text-green-400' : ($contact->is_read ? 'bg-blue-500/20 text-blue-400' : 'bg-yellow-500/20 text-yellow-400') }}">
                {{ $contact->is_replied ? 'Dibalas' : ($contact->is_read ? 'Dibaca' : 'Belum Dibaca') }}
            </span>
            <span class="text-gray-500 text-xs whitespace-nowrap">
                {{ $contact->created_at->diffForHumans() }}
            </span>
        </div>
    </div>
</div>