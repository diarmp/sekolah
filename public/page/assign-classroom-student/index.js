// $(function(){

//     const tableStudents = $("#students")

//     const tableClassroomStudents = $("#students-classroom")

//     const btnStore = $("#assign-classroom-store")

//     const btnDestroy = $("#assign-classroom-delete")

//     const classroomId = $("#classroom_id")

//     const setClassroomId = $("input[name='classroom_id']")

//     const columns = [
//         {"data": "id"},
//         {"data": "nis"},
//         {"data": "name"},
//         {"data": "dob"}
//     ];


//     var selectedStudentStore = new Set()
//     var selectedStudentDelete = new Set()
//     var classroomSetData = {}

//     var hideBtn = (id,data) =>{data.size >= 1 ? id.show() : id.hide() };

//     hideBtn(btnStore,selectedStudentStore)
//     hideBtn(btnDestroy,selectedStudentDelete)

//     var selectedStore = (e) => {
//         let isSelected = $(e).is(":checked");
//         let valSelected = parseInt($(e).val());
//         if (isSelected) {
//             $(e).parent().parent().addClass("selected")
//             selectedStudentStore.add(valSelected)
//         } else {
//             $(e).parent().parent().removeClass("selected")
//             selectedStudentStore.delete(valSelected)
//         }
//         hidBtn(btnStore,selectedStudentStore)
//     }

//     var selectedDestroy = (e) => {
//         let isSelected = $(e).is(":checked");
//         let valSelected = parseInt($(e).val());
//         if (isSelected) {
//             $(e).parent().parent().addClass("selected")
//             selectedStudentDelete.add(valSelected)
//         } else {
//             $(e).parent().parent().removeClass("selected")
//             selectedStudentDelete.delete(valSelected)
//         }
//         hidBtn(btnDestroy,selectedStudentDelete)
//     }

//     var appenDataStudent = (data,btn) => {
//         for (var it = data.values(), val = null; val = it.next().value;) {
//             btn.append(`<input type="hidden" name="id[]" value="${val}" /> `)
//         }
//     }

//     var setDataClassroomID = ()=>{
//         let classroom_id = classroomId.find(":selected").val()
//         setClassroomId.val(classroom_id)
//         classroomSetData.classroom_id = classroom_id

//     }

//     var reloadajax = (datatable) => {
//         setDataClassroomID()
//         datatable.ajax.reload(null, false)
//     }

//     var datatableStudent = (table,url,dataSelected,selectedRowFun)  =>{
//         setDataClassroomID()
//         table.DataTable({
//             processing: true,
//             serverSide: true,
//             ajax: {
//                 data: function(d) {
//                     return $.extend(d, classroomSetData)
//                 },
//                 url: url
//             },
//             columns: columns,
//             'columnDefs': [{
//                 'targets': 0,
//                 'searchable': false,
//                 'orderable': false,
//                 'className': 'dt-body-center',
//                 'render': function(data, type, full, meta) {

//                     let isChecked = dataSelected.has(data) ? 'checked' : '';
//                     return `<input type="checkbox" name="id[]" onclick="${selectedRowFun}()" value="${data}" ${isChecked} />`
//                 }
//             }],
//             'order': [2, 'asc'],
//             createdRow: function(row, data, dataIndex) {
//                 if (dataSelected.has(data.id)) {
//                     $(row).addClass('selected');
//                 } else {
//                     $(row).removeClass('selected');
//                 }
//             }
//         });
//     }


//     btnStore.click(()=>{
//         appenDataStudent(selectedStudentStore,btnStore)
//     });

//     btnDestroy.click(()=>{
//         appenDataStudent(selectedStudentDelete,btnDestroy)
//     });

//     /**TABLE STUDENT LIST */

//    var datatableStudents = datatableStudent(
//                     tableStudents,
//                     route('datatable.students'),
//                     selectedStudentStore,
//                     'selectedStore'
//                     )

// //  var datatableStudentRoom = datatableStudent(
// //                         tableClassroomStudents,
// //                         selectedStudentDelete,
// //                         route('datatable.assign-classroom-student'),
// //                         'selectedDestroy'
// //                     )
// classroomId.change(function() {
//     reloadajax(datatableStudentRoom)
//  });


//     /**END STUDENT LIST */


// })
