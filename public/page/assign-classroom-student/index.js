$(function(){

    const tableStudents = $("#students")

    const tableClassroomStudents = $("#students-classroom")

    const btnStore = $("#assign-classroom-store")

    const btnDestroy = $("#assign-classroom-delete")

    const classroomId = $("#classroom_id")

    const setClassroomId = $("input[name='classroom_id']")

    const coulmns = [
        {"data": "id"},
        {"data": "nis"},
        {"data": "name"},
        {"data": "dob"}
    ];

    var selectedStudent = new Set()
    var selectedStudentDelete = new Set()
    var classroomSetData = {}



    /**TABLE STUDENT LIST */


    /**END STUDENT LIST */


})
