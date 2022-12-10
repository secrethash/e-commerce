@if(session('notice'))
	@php
		$successEmoticons = collect([
			'🎉',
			'🤩',
			'🎊',
			'🥳',
			'👏',
		]);
		$infoEmoticons = collect([
			'😇',
			'🤩',
			'🤓',
			'😄',
			'😃',
		]);
		$primaryEmoticons = collect([
			'✌',
			'👌',
			'🤓',
			'😉',
			'😊',
		]);
		$warningEmoticons = collect([
			'🧐',
			'😬',
			'🤔',
			'🙈',
			'🖖',
		]);
		$dangerEmoticons = collect([
			'🥶',
			'😳',
			'🤕',
			'🥺',
			'😶',
		]);

	@endphp
	@foreach (session('notice') as $notice)
		@php
			$emoticon = '';
			
			if ($notice['type']==='success') {
				$emoticon = $successEmoticons->random();
			}elseif ($notice['type']==='info') {
				$emoticon = $infoEmoticons->random();
			}elseif ($notice['type']==='primary') {
				$emoticon = $primaryEmoticons->random();
			}elseif ($notice['type']==='warning') {
				$emoticon = $warningEmoticons->random();
			}elseif ($notice['type']==='error') {
				$emoticon = $dangerEmoticons->random();
			}

		@endphp

		@component('components.toaster', [
			'type' => $notice['type'],
			'position' => 'bottom-right',
			'heading' => $emoticon.' '.$notice['heading'],
		])
			{!! $notice['message'] !!}
		@endcomponent
	@endforeach
	{{-- @component('components.toaster', [
		'type' => session('notice.type'),
		'position' => 'bottom-right',
		'heading' => session('notice.heading'),
	])
		{!! session('notice.message') !!}
	@endcomponent --}}
@endif