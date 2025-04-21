<x-layout>

    <div class="card-body p-0 ccard overflow-hidden">
        <table class="table brc-black-tp11">
            <thead class="border-0">
                <tr class="border-0 bgc-dark-l5 text-dark-tp5">
                    <th class="border-0 pl-4">ID</th>
                    <th class="border-0">English Name</th>
                    <th class="border-0">Arabic Email</th>
                    <th class="border-0">Division / Department</th>
                    <th class="border-0">Is Active</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->employee_id }}</td>
                        <td>{{ $employee->english_name }}</td>
                        <td>{{ $employee->arabic_name }}</td>
                        <td>{{ $employee->division_department }}</td>
                        <td>{{ $employee->is_active }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</x-layout>
