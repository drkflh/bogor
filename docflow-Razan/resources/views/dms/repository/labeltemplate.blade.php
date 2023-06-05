<div style="border: thin solid grey; border-radius: 8px;padding: 16px;text-align: center;display: table;width: 100%;" >
    <table style="width: fit-content;margin: auto;">
        <tr>
            <td style="width: 80px !important;max-width: 80px;">
                <qrcode
                        :value="content"
                        :options="{ width: 70, height: 70, errorCorrectionLevel: 'M', mode: 'alphanumeric' }"
                        tag="img"
                >
                </qrcode>
            </td>
            <td style="vertical-align: middle;text-align: left;padding-left: 4px;">
                <p class="h5" style="text-wrap: none;margin-top: 8px;font-size:11pt !important;font-weight:bold;text-align: left;" >@{{ content }}</p>
            </td>
        </tr>
    </table>
</div>
