<table>
    <thead>
    <tr>
        <th>Action</th>
        <th>Module</th>
        <th>Message</th>
        <th>By</th>
        <th>Date</th>
        <th>Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $record)
        <tr>
            <td>{{ $record->getExtraProperty('action') }}</td>
            <td>{{ $record->getExtraProperty('module') }}</td>
            <td>{{ $record->description }}</td>
            <td>{{ $record->causer?->name }}</td>
            <td>{{ $record->created_at->format('Y-m-d') }}</td>
            <td>{{ $record->created_at->format('H:i A') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
