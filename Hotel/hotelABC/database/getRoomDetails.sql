CREATE PROCEDURE GetRoomDetails
    @Status VARCHAR(10)
AS
BEGIN
    SELECT Id, Suite, Status
    FROM RoomTable
    WHERE Status = @Status;
END